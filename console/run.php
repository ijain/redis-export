<?php
/**
 * Run parsing and saving
 */

require 'vendor/autoload.php';

use App\Lib\File;
use App\Lib\XmlParser;
use App\Lib\RedisDataModel;
use App\Lib\Arguments;

$arguments = new Arguments($argv);
$values = $arguments->getActionValues();

if (!is_array($values)) {
   exit('Error in arguments processing');
}

$filePath = isset($values['file']) ? $values['file'] : '';
$printResult = isset($values['print']) ? $values['print'] : false;

$file = new File();
$file->setInputFile($filePath);

$xml = new XmlParser($file);

try {
    $redisStorage = new RedisDataModel($xml);
    $redisStorage->addSubDomains();
    $redisStorage->addCookies();

    if ($printResult) {
        $result = $redisStorage->print();

        if (empty($result)) {
            die('Error retrieving the data for printing');
        }

        print_r($result);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

