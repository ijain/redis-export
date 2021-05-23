<?php

namespace App\Lib;

/**
 * Class File
 * @package App\Lib
 */
class File
{
    /**
     * @var string $inputFile
     */
    protected $inputFile;

    /**
     * @return string
     */
    public function getInputFile() : string
    {
        if (!file_exists($this->inputFile)) {
            return '';
        }

        return $this->inputFile;
    }

    /**
     * @param string $inputFile
     */
    public function setInputFile(string $inputFile)
    {
        $this->inputFile = $inputFile;
    }
}