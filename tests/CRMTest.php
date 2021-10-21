<?php

declare(strict_types=1);

namespace Tests;

use Donttrythisathome\CRMClient\Contracts\CRMDriver;
use Donttrythisathome\CRMClient\CRMManager;
use PHPUnit\Framework\TestCase;

class CRMTest extends TestCase
{
    /** @var \Donttrythisathome\CRMClient\CRMManager|null */
    protected ?CRMManager $crm;

    public function setUp(): void
    {
        $this->crm = new CRMManager([
            'default' => 'baz',
            'drivers' => [
                'baz' => [
                    'endpoint' => 'https://jsonplaceholder.typicode.com/posts',
                    'api_key' => ''
                ]
            ]
        ]);
    }

    public function tearDown(): void
    {
        $this->crm = null;
    }

    public function testDefaultDriver(): void
    {
        $this->assertInstanceOf(CRMDriver::class, $this->crm->driver());
    }

    public function testExactDriver(): void
    {
        $this->assertInstanceOf(CRMDriver::class, $this->crm->driver('baz'));
    }

    public function testInvalidDriver(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->crm->driver('foo');
    }

    public function testSendDataToCRM(): void
    {
        $this->assertTrue($this->crm->send(['foo' => 'bar']));
    }
}