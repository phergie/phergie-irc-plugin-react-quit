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

use Phergie\Irc\Bot\React\AbstractPlugin;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Plugin for providing a command to instruct the bot to terminate a connection.
 *
 * @category Phergie
 * @package Phergie\Irc\Plugin\React\Quit
 */
class Plugin extends AbstractPlugin
{
    /**
     * Template for the "message" parameter for the IRC QUIT command sent by
     * this plugin
     *
     * @var string
     */
    protected $message = 'by request of %s';

    /**
     * Accepts plugin configuration.
     *
     * Supported keys:
     *
     * message - sprintf-compatible template string used to generate the
     * "message" parameter for the IRC QUIT command sent by this plugin;
     * takes a single parameter, a string containing the nick of the user who
     * initiated the command to quit
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        if (isset($config['message'])) {
            $this->message = $config['message'];
        }
    }

    /**
     * Indicates that the plugin monitors events for a "quit" command emitted
     * by the Command plugin and a corresponding help event emitted by the
     * CommandHelp plugin.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'command.quit' => 'handleQuitCommand',
            'command.quit.help' => 'handleQuitHelp',
        );
    }

    /**
     * Terminates the connection to a server from which a quit command is
     * received.
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleQuitCommand(CommandEvent $event, EventQueueInterface $queue)
    {
        $message = sprintf($this->message, $event->getNick());
        $queue->ircQuit($message);
    }

    /**
     * Displays help information for the quit command.
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleQuitHelp(CommandEvent $event, EventQueueInterface $queue)
    {
        $messages = array(
            'Usage: quit',
            'Requests that the bot terminate its connection to the current server.',
            'See https://tools.ietf.org/html/rfc2812#section-3.1.7',
        );

        $method = 'irc' . $event->getCommand();
        $target = $event->getSource();
        foreach ($messages as $message) {
            $queue->$method($target, $message);
        }
    }
}
