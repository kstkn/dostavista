<?php

namespace Dostavista;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

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
            throw new ParseException('JSON decode error: ' . json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new ParseException('Response is not an array');
        }

        if ($data['result'] === 0) {
            if (isset($data['error_message'], $data['error_message'][0])) {
                throw new RequestException($data['error_message'][0]);
            } else {
                throw new RequestException('Unknown request error');
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
     *
     * @return float
     * @throws ParseException
     */
    public function calculateOrder(OrderRequest $orderRequest): float
    {
        $data = $this->post('calculate', $orderRequest);

        if (!isset($data['payment'])) {
            throw new ParseException('Invalid response: "payment" key is missing. Response data: ' . json_encode($data));
        }

        return (float) $data['payment'];
    }

    /**
     * @param OrderRequest $orderRequest
     *
     * @return int Order ID
     * @throws ParseException
     */
    public function createOrder(OrderRequest $orderRequest): int
    {
        $data = $this->post('order', $orderRequest);

        if (!isset($data['order_id'])) {
            throw new ParseException('Invalid response: "order_id" key is missing. Response data: ' . json_encode($data));
        }

        return (int) $data['order_id'];
    }

    /**
     * @return array|Order[]
     * @throws ParseException
     */
    public function getOrders(): array
    {
        $data = $this->get('order');

        if (!isset($data['orders'])) {
            throw new ParseException('Invalid response: "orders" key is missing. Response data: ' . json_encode($data));
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
     *
     * @return Order
     * @throws ParseException
     */
    public function getOrder(int $id, $showPoints = false): Order
    {
        $data = $this->get('order/' . $id, [
            'show-points' => (int) $showPoints,
        ]);

        if (!isset($data['order'])) {
            throw new ParseException('Invalid response: "order" key is missing. Response data: ' . json_encode($data));
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

    protected function signEvent(BaseEvent $event): string
    {
        return md5($this->token . json_encode($event->asArray(), JSON_UNESCAPED_UNICODE));
    }

    public function getEvent(array $eventData): BaseEvent
    {
        $event = new BaseEvent($eventData['event'], $eventData['signature'], $eventData);
        if ($event->getSignature() !== $this->signEvent($event)) {
            throw new InvalidSignatureException('Could not validate received event. Event data: ' . json_encode($eventData));
        }

        return $event;
    }
}