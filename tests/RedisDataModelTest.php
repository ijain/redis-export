<?php

use PHPUnit\Framework\TestCase;
use App\Lib\XmlParser;
use App\Lib\File;
use Predis\Client;
use App\Lib\RedisDataModel;
use Predis\Connection\ConnectionException;

/**
 * Class XmlParserTest
 */
class RedisDataModelTest extends TestCase
{
    const DIRECTORY = './tests/tmp';
    const FILE = './tests/tmp/testConfig.xml';

    /**
     * @var XmlParser
     */
    protected $parser;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var Client
     */
    protected $redis;

    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * Initialize
     */
    public function setUp() : void
    {
        $this->file = new File();
        $this->file->setInputFile(self::FILE);
        $this->parser = new XmlParser($this->file);

        try {
            $this->redis = new RedisDataModel($this->parser);
        } catch (ConnectionException $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
    }

    /**
     * Cleanup
     */
    public function tearDown() : void
    {
        if($this->redis) {
            $this->redis->flush();
            unset($this->redis);
        }

        if($this->file) {
            unset($this->file);
        }

        if($this->parser) {
            unset($this->parser);
        }
    }

    /**
     * Test setup objects
     */
    public function testSetUp()
    {
        $this->assertInstanceOf(File::class, $this->file);
        $this->assertInstanceOf(XmlParser::class, $this->parser);

        $this->assertDirectoryIsReadable(self::DIRECTORY, 'Directory is not readable');
        $this->assertFileExists($this->file->getInputFile());
    }

    /**
     * Test result data array
     */
    public  function testSubDomainsArray()
    {
        $data = $this->parser->iteration('subdomains');
        $subdomains = (array)$data[0]->subdomain;

        $this->assertIsArray($subdomains);
        $this->assertNotEmpty($subdomains);
        $this->assertTrue(count($subdomains) > 0);
    }

    /**
     * Test result data json
     */
    public  function testSubDomainsJson()
    {
        $data = $this->parser->iteration('subdomains');
        $subdomains = (array)$data[0]->subdomain;
        $subdomainsJson = json_encode($subdomains);

        $this->assertJson($subdomainsJson);
        $this->assertNotEmpty($subdomainsJson);
    }

    /**
     * Test result data array
     */
    public  function testCookiesArray()
    {
        $data = $this->parser->iteration('cookies/cookie');
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertTrue(count($data) > 0);
    }

    /**
     * Test add subdomains
     */
    public function testAddSubdomainsToRedis()
    {
        $response = $this->redis->addSubDomains();
        $this->assertTrue($response);
    }

    /**
     * Test add cookies
     */
    public function testAddCookiesToRedis()
    {
        $response = $this->redis->addCookies();
        $this->assertTrue($response);
    }

    /**
     * Test data processing
     */
    public function testPrintRedisKeys()
    {
        $file = new File();
        $file->setInputFile(self::FILE);

        $xml = new XmlParser($file);
        $redisStorage = new RedisDataModel($xml);

        $redisStorage->addSubDomains();
        $redisStorage->addCookies();

        $data = $redisStorage->print();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertTrue(count($data) > 0);
    }
}