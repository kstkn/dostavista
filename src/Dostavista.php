<?php

namespace Dostavista;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Dostavista
{
    use ConfigureTrait;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    protected $clientId;

    protected $token;

    protected $baseUrl;

    public function __construct(ClientInterface $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->configure($config);
    }

    protected function parseResponse(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('JSON decode error: ' . json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new RuntimeException('Response is not an array');
        }

        if ($data['result'] === 0) {
            if (isset($data['error_message'], $data['error_message'][0])) {
                throw new RuntimeException($data['error_message'][0]);
            } else {
                throw new RuntimeException('Unknown request error');
            }
        }

        unset($data['result']);

        return $data;
    }

    protected function post(string $endPoint, Exportable $request): array
    {
        $response = $this->httpClient->request('post', $this->baseUrl . '/' . $endPoint, [
            'form_params' => array_merge(
                [
                    'client_id' => $this->clientId,
                    'token' => $this->token,
                ],
                $request->export()
            )
        ]);

        return $this->parseResponse($response);
    }

    protected function get(string $endPoint, array $params = []): array
    {
        $response = $this->httpClient->request('get', $this->baseUrl . '/' . $endPoint, [
            'query' => array_merge(
                [
                    'client_id' => $this->clientId,
                    'token' => $this->token,
                ],
                $params
            )
        ]);

        return $this->parseResponse($response);
    }

    /**
     * @param OrderRequest $orderRequest
     * @return int Order ID
     */
    public function createOrder(OrderRequest $orderRequest): int
    {
        $data = $this->post('order', $orderRequest);

        if (!isset($data['order_id'])) {
            throw new RuntimeException('Invalid response: "order_id" key is missing. Response data: ' . json_encode($data));
        }

        return (int) $data['order_id'];
    }

    /**
     * @return Order[]
     */
    public function getOrders(): array
    {
        $data = $this->get('order');

        if (!isset($data['orders'])) {
            throw new RuntimeException('Invalid response: "orders" key is missing. Response data: ' . json_encode($data));
        }

        $result = [];
        foreach ($data['orders'] as $orderData) {
            $result[] = new Order($orderData);
        }

        return $result;
    }

    /**
     * @param int $id
     * @param bool $showPoints
     * @return Order
     */
    public function getOrder(int $id, $showPoints = false): Order
    {
        $data = $this->get('order/' . $id, [
            'show-points' => (int) $showPoints,
        ]);

        if (!isset($data['order'])) {
            throw new RuntimeException('Invalid response: "order" key is missing. Response data: ' . json_encode($data));
        }

        return new Order($data['order']);
    }

    /**
     * @param CancelRequest $cancelRequest
     */
    public function cancelOrder(CancelRequest $cancelRequest)
    {
        $this->post('cancel-order', $cancelRequest);
    }
}