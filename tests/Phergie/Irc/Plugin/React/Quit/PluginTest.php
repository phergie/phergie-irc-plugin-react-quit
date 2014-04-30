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
     * Data provider for testHandleHelp().
     *
     * @return array
     */
    public function dataProviderHandleHelp()
    {
        $data = array();
        $data[] = array('#channel', '#channel');
        $data[] = array('bot', 'user');
        return $data;
    }

    /**
     * Tests handleQuitHelp().
     *
     * @param string $requestTarget
     * @param string $responseTarget
     * @dataProvider dataProviderHandleHelp
     */
    public function testHandleHelp($requestTarget, $responseTarget)
    {
        $connection = $this->getMockConnection();
        Phake::when($connection)->getNickname()->thenReturn('bot');

        $event = $this->getMockCommandEvent();
        Phake::when($event)->getCustomParams()->thenReturn(array());
        Phake::when($event)->getConnection()->thenReturn($connection);
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        Phake::when($event)->getTargets()->thenReturn(array($requestTarget));
        Phake::when($event)->getNick()->thenReturn('user');
        $queue = $this->getMockEventQueue();

        $plugin = new Plugin;
        $plugin->handleQuitHelp($event, $queue);

        Phake::verify($queue, Phake::atLeast(1))
            ->ircPrivmsg($responseTarget, $this->isType('string'));
    }

    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new Plugin;
        $this->assertInternalType('array', $plugin->getSubscribedEvents());
    }

    /**
     * Returns a mock connection.
     *
     * @return \Phergie\Irc\ConnectionInterface
     */
    protected function getMockConnection()
    {
        return Phake::mock('\Phergie\Irc\ConnectionInterface');
    }

    /**
     * Returns a mock command event.
     *
     * @return \Phergie\Irc\Plugin\React\Command\CommandEvent
     */
    protected function getMockCommandEvent()
    {
        return Phake::mock('Phergie\Irc\Plugin\React\Command\CommandEvent');
    }

    /**
     * Returns a mock event queue.
     *
     * @return \Phergie\Irc\Bot\React\EventQueueInterface
     */
    protected function getMockEventQueue()
    {
        return Phake::mock('Phergie\Irc\Bot\React\EventQueueInterface');
    }
}
