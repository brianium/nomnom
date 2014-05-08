<?php
namespace Nomnom;

class Filesize extends Nomnom
{
    public function __construct($file) 
    {
        if (! file_exists($file)) {
            throw new FileNotFoundException("File $file does not exist");
        }
        parent::__construct(filesize($file));
    }

    public function from($unit) 
    {
        throw new \RuntimeException("Nomnom::from method not supported on files");
    }
}
