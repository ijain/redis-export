<?php

namespace App\Lib;

use Predis\Client;
use Exception;

/**
 * Class RedisDataModel
 * @package App\Lib
 */
class RedisDataModel
{
    const HOST = '127.0.0.1';
    //const HOST = 'redis';

    /**
     * @var Client
     */
    private $redis;

    /**
     * @var XmlParser
     */
    private $xml;

    /**
     * RedisDataModel constructor.
     * @param XmlParser $xml
     */
    public function __construct(XmlParser $xml = null)
    {
        try {
            $this->redis = new Client([
                'host' => self::HOST
            ]);

            $this->redis->connect();

            if (!$this->redis->isConnected()) {
                throw new \Exception("Cannot connect to Redis. Hostname: " . self::HOST);
            }

            $this->xml = $xml;
        } catch (Exception $e) {
            $this->redis = null;
            echo $e->getMessage();
        }
    }

    /**
     * add subdomains key=>value to redis (json format)
     * @return bool
     */
    public function addSubDomains()
    {
        if (!$this->xml) {
            throw new Exception('Xml is set to null. This is acceptable only for print() and delete() method.');
        }

        try {
            $subdomainItems = $this->xml->iteration("subdomains");
            $subdomains = json_encode((array)$subdomainItems[0]->subdomain);
            $this->redis->set('subdomains', $subdomains);

            return  true;
        } catch (Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    /**
     * add cookies key=>value to redis
     * @return bool
     */
    public function addCookies()
    {
        if (!$this->xml) {
            throw new Exception('Xml is set to null. This is acceptable only for print() and delete() method.');
        }

        try {
            $cookies = $this->xml->iteration("cookies/cookie");

            foreach ($cookies as $cookie) {
                $node = (array)$cookie;
                $name = $node['@attributes']['name'];
                $host = $node['@attributes']['host'];
                $value = $node[0];

                $this->redis->set('cookie:' . $name . ':' . $host, $value);
            }

            return  true;
        } catch (Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    /**
     * @param string $key
     * @return array
     */
    public function print(string $key = '*')
    {
        $result = [];

        if ($this->redis) {
            $result = $this->redis->keys($key);
        }

        return $result;
    }

    /**
     * @param string $key
     */
    public function delete(string $key = '*')
    {
        if ($this->redis) {
            $this->redis->del($this->redis->keys($key));
        } else {
            echo 'Redis object does not exists for deleting';
        }
    }

    /**
     * delete all from db
     */
    public function flush()
    {
        if ($this->redis) {
            $this->redis->flushdb();
        } else {
            echo 'Redis object does not exists';
        }
    }
}
