# This project is abandoned

This repo is being kept for posterity and will be archived in a readonly state. 
If you're interested it can be forked under a new Composer namespace/GitHub organization.

# phergie/phergie-irc-plugin-react-quit

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin for providing a command to instruct the bot to terminate a connection.

[![Build Status](https://secure.travis-ci.org/phergie/phergie-irc-plugin-react-quit.png?branch=master)](http://travis-ci.org/phergie/phergie-irc-plugin-react-quit)

## Install

The recommended method of installation is [through composer](http://getcomposer.org).

```
composer require phergie/phergie-irc-plugin-react-quit
```

See Phergie documentation for more information on
[installing and enabling plugins](https://github.com/phergie/phergie-irc-bot-react/wiki/Usage#plugins).

Note that this plugin depends on the
[Command plugin](https://github.com/phergie/phergie-irc-plugin-react-command)
plugin, which is installed as a dependency by composer but must still be
enabled in your Phergie configuration file to be available to this plugin.

## Configuration

```php
return array(
    'plugins' = array(
        new \Phergie\Irc\Plugin\React\Command\Plugin, // dependency
        
        new \Phergie\Irc\Plugin\React\Quit\Plugin(array(
        
            // Optional: sprintf-compatible template for the message sent when the bot
            // quits; takes one parameter, a string containing the nick of the user who
            // initiated the command to quit
            'message' => 'because %s said so',
        
        )),
    )
);
```

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

## License

Released under the BSD License. See `LICENSE`.
