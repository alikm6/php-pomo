# PHP package for multi-lingualizing scripts using PO and MO files

## Introduction

POMO is a PHP package that allows you to write multi-language scripts in PHP using PO and MO files. You can use the POEdit application to create and edit these files, making it easy to translate your application into multiple languages. This package is suitable for developers who want to create multilingual PHP applications with minimal effort.

## Installation

To install POMO, use Composer and run the following command:

```consol
composer require alikm6/php-pomo
```

## Usage

To use POMO in your PHP application, you need to require the functions file located in `vendor/alikm6/php-pomo/l10n.php`. Once you have required this file, you can select the target MO file using the following code:

```php
unload_textdomain('default');
load_textdomain('default', "languages/{$language_code}.mo");
```

Replace `$language_code` with the appropriate language code for the language you want to use. Once you have loaded the target MO file, you can translate text using the __() function, for example:

```php
__("Hello World")
```

This function will return the translated text, if it is available in the loaded MO file.

## License

This package is licensed under the MIT License. See the LICENSE file for details.


## Credits
POMO is inspired by the POMO package used in WordPress. The files used in this package are located at:

- https://github.com/WordPress/WordPress/tree/master/wp-includes/pomo
- https://github.com/WordPress/WordPress/blob/master/wp-includes/l10n.php

The required changes have been made on these files and they have been used in this package.
