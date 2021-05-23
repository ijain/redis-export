<?php

use PHPUnit\Framework\TestCase;
use Predis\Client;
use Predis\Connection\ConnectionException;

/**
 * Class RedisConnectionTest
 */
class RedisConnectionTest extends TestCase
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var Client
     */
    protected $redis;

    /**
     * Test init
     */
    public function setUp() : void
    {
        $this->host = '127.0.0.1';
    }

    public function tearDown() : void
    {
        unset($this->redis);
    }

    /**
     * Test result data json
     */
    public  function testRedisConnection()
    {
        try {
            $this->redis = new Client([
                'host' => $this->host
            ]);

            $this->redis->connect();
            $this->assertTrue($this->redis->isConnected());
        } catch (ConnectionException $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
    }
}