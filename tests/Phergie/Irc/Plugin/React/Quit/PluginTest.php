<?php
/**
 * Phergie (http://phergie.org)
 *
 * @link https://github.com/phergie/phergie-irc-plugin-react-quit for the canonical source repository
 * @copyright Copyright (c) 2008-2014 Phergie Development Team (http://phergie.org)
 * @license http://phergie.org/license New BSD License
 * @package Phergie\Irc\Plugin\React\Quit
 */

namespace Phergie\Irc\Plugin\React\Quit;

use Phake;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Tests for the Plugin class.
 *
 * @category Phergie
 * @package Phergie\Irc\Plugin\React\Quit
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests handleQuitCommand() with the default message.
     */
    public function testHandleQuitCommandWithDefaultMessage()
    {
        $event = Phake::mock('Phergie\Irc\Plugin\React\Command\CommandEvent');
        Phake::when($event)->getNick()->thenReturn('nickname');

        $queue = Phake::mock('Phergie\Irc\Bot\React\EventQueueInterface');

        $plugin = new Plugin;
        $plugin->handleQuitCommand($event, $queue);

        Phake::verify($queue)->ircQuit('by request of nickname');
    }

    /**
     * Tests handleQuitCommand() with a custom message.
     */
    public function testHandleQuitCommandWithCustomMessage()
    {
        $event = Phake::mock('Phergie\Irc\Plugin\React\Command\CommandEvent');
        Phake::when($event)->getNick()->thenReturn('nickname');

        $queue = Phake::mock('Phergie\Irc\Bot\React\EventQueueInterface');

        $plugin = new Plugin(array('message' => 'because %s said so'));
        $plugin->handleQuitCommand($event, $queue);

        Phake::verify($queue)->ircQuit('because nickname said so');
    }

    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new Plugin;
        $this->assertInternalType('array', $plugin->getSubscribedEvents());
    }
}
