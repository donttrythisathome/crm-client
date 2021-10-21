<?php

declare(strict_types=1);

namespace Donttrythisathome\CRMClient\Drivers;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Donttrythisathome\CRMClient\Contracts\CRMDriver;

/**
 * В задачке метод \App\BazSender::send(array $data): int возвращает 200, поэтому можно предположить, что в качестве
 * транспорта используем http.
 */
class Baz implements CRMDriver
{
    protected ClientInterface $transport;

    /** @var array */
    protected array $config;

    /**
     * @param \GuzzleHttp\ClientInterface $transport
     * @param array $config
     */
    public function __construct(ClientInterface $transport, array $config)
    {
        $this->transport = $transport;
        $this->config = $config;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $data): bool
    {
        try {
            $this->transport->request('POST', $this->config['endpoint'], [
                RequestOptions::JSON => $data,
                RequestOptions::HTTP_ERRORS => true,
                RequestOptions::HEADERS => [
                    // В задачке фигурирует метод setCredentials, поэтому предположим что нам нужно аутентифицироваться
                    // например по bearer токену
                    'Authorization' => sprintf('Bearer %s', $this->config['api_key'])
                ]
            ]);

        } catch (ClientException $e) {
            return false;
        }

        return true;
    }
}