<?php /** @noinspection PhpUnused */

namespace Donttrythisathome\CRMClient;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Donttrythisathome\CRMClient\Drivers\Baz;
use Donttrythisathome\CRMClient\Contracts\CRMDriver;

/**
 * Конечно тут круто было бы наследоваться от \Illuminate\Support\Manager, но в задачке не сказано где и как мы будем
 * запускать это, поэтому рассмотрим общий случай со сферическим приложением на PHP ^7.4 вакууме. Мало ли у нас какой-то
 * самописный фреймворк, и хорошо бы он поддерживал PSR-0 / PSR-4
 *
 * @method bool send(array $dta)
 */
class CRMManager
{
    /** @var array */
    protected array $drivers = [];

    /** @var array */
    protected array $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string|null $driver
     * @return \Donttrythisathome\CRMClient\Contracts\CRMDriver
     */
    public function driver(?string $driver = null): CRMDriver
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (is_null($driver)) {
            throw new InvalidArgumentException('There is no default driver for CRMManager');
        }


        if (!isset($this->drivers['name'])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * @param string $driver
     * @return \Donttrythisathome\CRMClient\Contracts\CRMDriver
     */
    protected function createDriver(string $driver): CRMDriver
    {
        $method = sprintf('create%sDriver', ucfirst($driver));

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException(sprintf('Driver [%s] is not supported.', $driver));
    }

    /**
     * @return \Donttrythisathome\CRMClient\Drivers\Baz
     */
    protected function createBazDriver(): Baz
    {
        return new Baz(new Client, $this->config['drivers']['baz']);
    }

    // extend driver creators here

    /**
     * @return string | null
     */
    public function getDefaultDriver(): ?string
    {
        return $this->config['default'];
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}