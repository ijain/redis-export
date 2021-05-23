<?php

namespace App\Lib;

/**
 * Class Arguments
 * @package App\Lib
 */
class Arguments
{
    /**
     * @var int
     */
    private $count;

    /**
     * @var array
     */
    private $argv;

    /**
     * @var bool
     */
    private $print = false;

    /**
     * Arguments constructor.
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->count = count($this->argv);
    }

    public function getActionValues()
    {
        switch ($this->count) {
            case 2:
                if (!file_exists($this->argv[1])) {
                    die('Invalid file path for argument #1');
                } else {
                    $filePath = $this->argv[1];
                }
                break;
            case 3:
                if ($this->argv[1] == '-v') {
                    $printResult = true;
                } else {
                    die('Invalid value for parameter #1, it must be -v');
                }

                if (!file_exists($this->argv[2])) {
                    die('Invalid file path for argument #2');
                } else {
                    $filePath = $this->argv[2];
                }
                break;
            default:
                die('Invalid number of arguments');
        }

        return [
            'file' => $filePath,
            'print' => $printResult
        ];
    }
}