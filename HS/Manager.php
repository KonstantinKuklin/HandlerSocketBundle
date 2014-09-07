<?php

/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\HandlerSocketBundle\HS;

use HS\ReaderInterface;
use HS\WriterHSInterface;

class Manager
{
    private $reader = null;
    private $writer = null;

    /**
     * @param ReaderInterface $reader
     * @param WriterHSInterface $writer
     */
    public function __construct(ReaderInterface $reader, WriterHSInterface $writer = null)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }


    /**
     * @return \HS\Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @return \HS\Writer
     */
    public function getWriter()
    {
        return $this->writer;
    }
} 