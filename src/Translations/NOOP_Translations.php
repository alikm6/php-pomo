<?php

namespace POMO\Translations;

use POMO\Entry\Translation_Entry;

/**
 * Provides the same interface as Translations, but doesn't do anything
 */
class NOOP_Translations
{
    public $entries = array();
    public $headers = array();

    public function add_entry($entry)
    {
        return true;
    }

    /**
     * @param string $header
     * @param string $value
     */
    public function set_header($header, $value)
    {
    }

    /**
     * @param array $headers
     */
    public function set_headers($headers)
    {
    }

    /**
     * @param string $header
     * @return false
     */
    public function get_header($header)
    {
        return false;
    }

    /**
     * @param Translation_Entry $entry
     * @return false
     */
    public function translate_entry(&$entry)
    {
        return false;
    }

    /**
     * @param string $singular
     * @param string $context
     */
    public function translate($singular, $context = null)
    {
        return $singular;
    }

    /**
     * @param int $count
     * @return bool
     */
    public function select_plural_form($count)
    {
        return 1 == $count ? 0 : 1;
    }

    /**
     * @return int
     */
    public function get_plural_forms_count()
    {
        return 2;
    }

    /**
     * @param string $singular
     * @param string $plural
     * @param int $count
     * @param string $context
     */
    public function translate_plural($singular, $plural, $count, $context = null)
    {
        return 1 == $count ? $singular : $plural;
    }

    /**
     * @param object $other
     */
    public function merge_with(&$other)
    {
    }
}