# phergie/phergie-irc-plugin-react-quit

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin for providing a command to instruct the bot to terminate a connection.

[![Build Status](https://secure.travis-ci.org/phergie/phergie-irc-plugin-react-quit.png?branch=master)](http://travis-ci.org/phergie/phergie-irc-plugin-react-quit)

## Install

The recommended method of installation is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "phergie/phergie-irc-plugin-react-quit": "dev-master"
    }
}
```

See Phergie documentation for more information on installing plugins.

## Configuration

```php
new \Phergie\Irc\Plugin\React\Quit\Plugin(array(



))
```

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
cd tests
../vendor/bin/phpunit
```

## License

Released under the BSD License. See `LICENSE`.
