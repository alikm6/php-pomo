<?php

namespace POMO\Streams;

/**
 * Reads the contents of the file in the beginning.
 */
class POMO_CachedIntFileReader extends POMO_CachedFileReader
{
    /**
     * PHP5 constructor.
     */
    public function __construct($filename)
    {
        parent::__construct($filename);
    }
}
