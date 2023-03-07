<?php
/**
 * Core Translation API
 *
 * @package WordPress
 * @subpackage i18n
 * @since 1.2.0
 */

use POMO\MO;
use POMO\Translations\NOOP_Translations;
use POMO\Translations\Translations;


/**
 * Retrieves the translation of $text.
 *
 * If there is no translation, or the text domain isn't loaded, the original text is returned.
 *
 * *Note:* Don't use translate() directly, use __() or related functions.
 *
 * @param string $text Text to translate.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                       Default 'default'.
 * @return string Translated text.
 * @since 5.5.0 Introduced `gettext-{$domain}` filter.
 *
 * @since 2.2.0
 */
function translate($text, $domain = 'default')
{
    $translations = get_translations_for_domain($domain);
    $translation = $translations->translate($text);

    return $translation;
}

/**
 * Removes last item on a pipe-delimited string.
 *
 * Meant for removing the last item in a string, such as 'Role name|User role'. The original
 * string will be returned if no pipe '|' characters are found in the string.
 *
 * @param string $text A pipe-delimited string.
 * @return string Either $text or everything before the last pipe.
 * @since 2.8.0
 *
 */
function before_last_bar($text)
{
    $last_bar = strrpos($text, '|');
    if (false === $last_bar) {
        return $text;
    } else {
        return substr($text, 0, $last_bar);
    }
}

/**
 * Retrieves the translation of $text in the context defined in $context.
 *
 * If there is no translation, or the text domain isn't loaded, the original text is returned.
 *
 * *Note:* Don't use translate_with_gettext_context() directly, use _x() or related functions.
 *
 * @param string $text Text to translate.
 * @param string $context Context information for the translators.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                        Default 'default'.
 * @return string Translated text on success, original text on failure.
 * @since 2.8.0
 * @since 5.5.0 Introduced `gettext_with_context-{$domain}` filter.
 *
 */
function translate_with_gettext_context($text, $context, $domain = 'default')
{
    $translations = get_translations_for_domain($domain);
    $translation = $translations->translate($text, $context);

    return $translation;
}

/**
 * Retrieves the translation of $text.
 *
 * If there is no translation, or the text domain isn't loaded, the original text is returned.
 *
 * @param string $text Text to translate.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                       Default 'default'.
 * @return string Translated text.
 * @since 2.1.0
 *
 */
function __($text, $domain = 'default')
{
    return translate($text, $domain);
}

/**
 * Displays translated text.
 *
 * @param string $text Text to translate.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                       Default 'default'.
 * @since 1.2.0
 *
 */
function _e($text, $domain = 'default')
{
    echo translate($text, $domain);
}

/**
 * Retrieves translated string with gettext context.
 *
 * Quite a few times, there will be collisions with similar translatable text
 * found in more than two places, but with different translated context.
 *
 * By including the context in the pot file, translators can translate the two
 * strings differently.
 *
 * @param string $text Text to translate.
 * @param string $context Context information for the translators.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                        Default 'default'.
 * @return string Translated context string without pipe.
 * @since 2.8.0
 *
 */
function _x($text, $context, $domain = 'default')
{
    return translate_with_gettext_context($text, $context, $domain);
}

/**
 * Displays translated string with gettext context.
 *
 * @param string $text Text to translate.
 * @param string $context Context information for the translators.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                        Default 'default'.
 * @since 3.0.0
 *
 */
function _ex($text, $context, $domain = 'default')
{
    echo _x($text, $context, $domain);
}

/**
 * Translates and retrieves the singular or plural form based on the supplied number.
 *
 * Used when you want to use the appropriate form of a string based on whether a
 * number is singular or plural.
 *
 * Example:
 *
 *     printf( _n( '%s person', '%s people', $count, 'text-domain' ), number_format_i18n( $count ) );
 *
 * @param string $single The text to be used if the number is singular.
 * @param string $plural The text to be used if the number is plural.
 * @param int $number The number to compare against to use either the singular or plural form.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                       Default 'default'.
 * @return string The translated singular or plural form.
 * @since 5.5.0 Introduced `ngettext-{$domain}` filter.
 *
 * @since 2.8.0
 */
function _n($single, $plural, $number, $domain = 'default')
{
    $translations = get_translations_for_domain($domain);
    $translation = $translations->translate_plural($single, $plural, $number);

    return $translation;
}

/**
 * Translates and retrieves the singular or plural form based on the supplied number, with gettext context.
 *
 * This is a hybrid of _n() and _x(). It supports context and plurals.
 *
 * Used when you want to use the appropriate form of a string with context based on whether a
 * number is singular or plural.
 *
 * Example of a generic phrase which is disambiguated via the context parameter:
 *
 *     printf( _nx( '%s group', '%s groups', $people, 'group of people', 'text-domain' ), number_format_i18n( $people ) );
 *     printf( _nx( '%s group', '%s groups', $animals, 'group of animals', 'text-domain' ), number_format_i18n( $animals ) );
 *
 * @param string $single The text to be used if the number is singular.
 * @param string $plural The text to be used if the number is plural.
 * @param int $number The number to compare against to use either the singular or plural form.
 * @param string $context Context information for the translators.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                        Default 'default'.
 * @return string The translated singular or plural form.
 * @since 2.8.0
 * @since 5.5.0 Introduced `ngettext_with_context-{$domain}` filter.
 *
 */
function _nx($single, $plural, $number, $context, $domain = 'default')
{
    $translations = get_translations_for_domain($domain);
    $translation = $translations->translate_plural($single, $plural, $number, $context);

    return $translation;
}

/**
 * Registers plural strings in POT file, but does not translate them.
 *
 * Used when you want to keep structures with translatable plural
 * strings and use them later when the number is known.
 *
 * Example:
 *
 *     $message = _n_noop( '%s post', '%s posts', 'text-domain' );
 *     ...
 *     printf( translate_nooped_plural( $message, $count, 'text-domain' ), number_format_i18n( $count ) );
 *
 * @param string $singular Singular form to be localized.
 * @param string $plural Plural form to be localized.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                         Default null.
 * @return array {
 *     Array of translation information for the strings.
 *
 * @type string      $0        Singular form to be localized. No longer used.
 * @type string      $1        Plural form to be localized. No longer used.
 * @type string $singular Singular form to be localized.
 * @type string $plural Plural form to be localized.
 * @type null $context Context information for the translators.
 * @type string|null $domain Text domain.
 * }
 * @since 2.5.0
 *
 */
function _n_noop($singular, $plural, $domain = null)
{
    return array(
        0 => $singular,
        1 => $plural,
        'singular' => $singular,
        'plural' => $plural,
        'context' => null,
        'domain' => $domain,
    );
}

/**
 * Registers plural strings with gettext context in POT file, but does not translate them.
 *
 * Used when you want to keep structures with translatable plural
 * strings and use them later when the number is known.
 *
 * Example of a generic phrase which is disambiguated via the context parameter:
 *
 *     $messages = array(
 *          'people'  => _nx_noop( '%s group', '%s groups', 'people', 'text-domain' ),
 *          'animals' => _nx_noop( '%s group', '%s groups', 'animals', 'text-domain' ),
 *     );
 *     ...
 *     $message = $messages[ $type ];
 *     printf( translate_nooped_plural( $message, $count, 'text-domain' ), number_format_i18n( $count ) );
 *
 * @param string $singular Singular form to be localized.
 * @param string $plural Plural form to be localized.
 * @param string $context Context information for the translators.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                         Default null.
 * @return array {
 *     Array of translation information for the strings.
 *
 * @type string      $0        Singular form to be localized. No longer used.
 * @type string      $1        Plural form to be localized. No longer used.
 * @type string      $2        Context information for the translators. No longer used.
 * @type string $singular Singular form to be localized.
 * @type string $plural Plural form to be localized.
 * @type string $context Context information for the translators.
 * @type string|null $domain Text domain.
 * }
 * @since 2.8.0
 *
 */
function _nx_noop($singular, $plural, $context, $domain = null)
{
    return array(
        0 => $singular,
        1 => $plural,
        2 => $context,
        'singular' => $singular,
        'plural' => $plural,
        'context' => $context,
        'domain' => $domain,
    );
}

/**
 * Translates and returns the singular or plural form of a string that's been registered
 * with _n_noop() or _nx_noop().
 *
 * Used when you want to use a translatable plural string once the number is known.
 *
 * Example:
 *
 *     $message = _n_noop( '%s post', '%s posts', 'text-domain' );
 *     ...
 *     printf( translate_nooped_plural( $message, $count, 'text-domain' ), number_format_i18n( $count ) );
 *
 * @param array $nooped_plural {
 *     Array that is usually a return value from _n_noop() or _nx_noop().
 *
 * @type string $singular Singular form to be localized.
 * @type string $plural Plural form to be localized.
 * @type string|null $context Context information for the translators.
 * @type string|null $domain Text domain.
 * }
 * @param int $count Number of objects.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings. If $nooped_plural contains
 *                              a text domain passed to _n_noop() or _nx_noop(), it will override this value. Default 'default'.
 * @return string Either $singular or $plural translated text.
 * @since 3.1.0
 *
 */
function translate_nooped_plural($nooped_plural, $count, $domain = 'default')
{
    if ($nooped_plural['domain']) {
        $domain = $nooped_plural['domain'];
    }

    if ($nooped_plural['context']) {
        return _nx($nooped_plural['singular'], $nooped_plural['plural'], $count, $nooped_plural['context'], $domain);
    } else {
        return _n($nooped_plural['singular'], $nooped_plural['plural'], $count, $domain);
    }
}

/**
 * Loads a .mo file into the text domain $domain.
 *
 * If the text domain already exists, the translations will be merged. If both
 * sets have the same string, the translation from the original value will be taken.
 *
 * On success, the .mo file will be placed in the $l10n global by $domain
 * and will be a MO object.
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @param string $mofile Path to the .mo file.
 * @param string $locale Optional. Locale. Default is the current locale.
 * @return bool True on success, false on failure.
 *
 * @since 1.5.0
 * @since 6.1.0 Added the `$locale` parameter.
 *
 * @global MO[] $l10n An array of all currently loaded text domains.
 * @global MO[] $l10n_unloaded An array of all text domains that have been unloaded again.
 */
function load_textdomain($domain, $mofile, $locale = null)
{
    global $l10n, $l10n_unloaded;

    $l10n_unloaded = (array)$l10n_unloaded;

    if (!is_readable($mofile)) {
        return false;
    }

    $mo = new MO();
    if (!$mo->import_from_file($mofile)) {
        return false;
    }

    if (isset($l10n[$domain])) {
        $mo->merge_with($l10n[$domain]);
    }

    unset($l10n_unloaded[$domain]);

    $l10n[$domain] = &$mo;

    return true;
}

/**
 * Unloads translations for a text domain.
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @param bool $reloadable Whether the text domain can be loaded just-in-time again.
 * @return bool Whether textdomain was unloaded.
 * @global MO[] $l10n_unloaded An array of all text domains that have been unloaded again.
 *
 * @since 3.0.0
 * @since 6.1.0 Added the `$reloadable` parameter.
 *
 * @global MO[] $l10n An array of all currently loaded text domains.
 */
function unload_textdomain($domain, $reloadable = false)
{
    global $l10n, $l10n_unloaded;

    $l10n_unloaded = (array)$l10n_unloaded;

    if (isset($l10n[$domain])) {
        unset($l10n[$domain]);

        if (!$reloadable) {
            $l10n_unloaded[$domain] = true;
        }

        return true;
    }

    return false;
}

/**
 * Returns the Translations instance for a text domain.
 *
 * If there isn't one, returns empty Translations instance.
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @return Translations|NOOP_Translations A Translations instance.
 * @since 2.8.0
 *
 * @global MO[] $l10n An array of all currently loaded text domains.
 *
 */
function get_translations_for_domain($domain)
{
    global $l10n;
    if (isset($l10n[$domain])) {
        return $l10n[$domain];
    }

    static $noop_translations = null;
    if (null === $noop_translations) {
        $noop_translations = new NOOP_Translations();
    }

    return $noop_translations;
}

/**
 * Determines whether there are translations for the text domain.
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @return bool Whether there are translations.
 * @since 3.0.0
 *
 * @global MO[] $l10n An array of all currently loaded text domains.
 *
 */
function is_textdomain_loaded($domain)
{
    global $l10n;
    return isset($l10n[$domain]);
}

/**
 * Gets all available languages based on the presence of *.mo files in a given directory.
 *
 * The default directory is 'languages'.
 *
 * @param string $dir A directory to search for language files.
 *                    Default 'languages'.
 * @return string[] An array of language codes or an empty array if no languages are present.
 *                  Language codes are formed by stripping the .mo extension from the language file names.
 * @since 3.0.0
 * @since 4.7.0 The results are now filterable with the {@see 'get_available_languages'} filter.
 *
 */
function get_available_languages($dir = null)
{
    $languages = array();

    $lang_files = glob((is_null($dir) ? 'languages' : $dir) . '/*.mo');
    if ($lang_files) {
        foreach ($lang_files as $lang_file) {
            $lang_file = basename($lang_file, '.mo');
            if (0 !== strpos($lang_file, 'continents-cities') && 0 !== strpos($lang_file, 'ms-') &&
                0 !== strpos($lang_file, 'admin-')) {
                $languages[] = $lang_file;
            }
        }
    }
}

/**
 * Translates the provided settings value using its i18n schema.
 *
 * @param string|string[]|array[]|object $i18n_schema I18n schema for the setting.
 * @param string|string[]|array[] $settings Value for the settings.
 * @param string $textdomain Textdomain to use with translations.
 *
 * @return string|string[]|array[] Translated settings.
 * @since 5.9.0
 * @access private
 *
 */
function translate_settings_using_i18n_schema($i18n_schema, $settings, $textdomain)
{
    if (empty($i18n_schema) || empty($settings) || empty($textdomain)) {
        return $settings;
    }

    if (is_string($i18n_schema) && is_string($settings)) {
        return translate_with_gettext_context($settings, $i18n_schema, $textdomain);
    }
    if (is_array($i18n_schema) && is_array($settings)) {
        $translated_settings = array();
        foreach ($settings as $value) {
            $translated_settings[] = translate_settings_using_i18n_schema($i18n_schema[0], $value, $textdomain);
        }
        return $translated_settings;
    }
    if (is_object($i18n_schema) && is_array($settings)) {
        $group_key = '*';
        $translated_settings = array();
        foreach ($settings as $key => $value) {
            if (isset($i18n_schema->$key)) {
                $translated_settings[$key] = translate_settings_using_i18n_schema($i18n_schema->$key, $value, $textdomain);
            } elseif (isset($i18n_schema->$group_key)) {
                $translated_settings[$key] = translate_settings_using_i18n_schema($i18n_schema->$group_key, $value, $textdomain);
            } else {
                $translated_settings[$key] = $value;
            }
        }
        return $translated_settings;
    }
    return $settings;
}
