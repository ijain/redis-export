<?php

namespace App\Lib;

/**
 * Class XmlParser
 * @package App\Lib
 */
class XmlParser
{
    /*
    * @property $xml SimpleXMLElement|bool
    */
    private $xml;

    /**
     * XmlParser constructor.
     *
     * @param $file File
     */
    public  function __construct(File $file)
    {
       try {
           $filePath = $file->getInputFile();
           $this->xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOCDATA);
        } catch (\Exception $e) {
           echo $e->getMessage();
       }
    }

    /**
     * @param $path
     * @return false|false[]|\SimpleXMLElement[]
     */
    public function iteration($path)
    {
        return $this->xml->xpath($path);
    }
}
