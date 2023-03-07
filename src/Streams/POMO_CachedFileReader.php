<?php

namespace POMO\Streams;

/**
 * Reads the contents of the file in the beginning.
 */
class POMO_CachedFileReader extends POMO_StringReader
{
    /**
     * PHP5 constructor.
     */
    public function __construct($filename)
    {
        parent::__construct();
        $this->_str = file_get_contents($filename);
        if (false === $this->_str) {
            return false;
        }
        $this->_pos = 0;
    }
}
