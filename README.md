# php-sdk
ATLPay Payment Gateway Integration PHP SDK
## Requirements

PHP 5.3.3 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require atlpay/php-sdk
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```



## Dependencies

The bindings require the following extension in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)
- [`guzzlehttp`](http://docs.guzzlephp.org/en/latest/) (HTTP Client)
- [`respectvalidation`](http://respect.github.io/Validation/) (Validation)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.