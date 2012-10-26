<?php
namespace kosssi\ManagerIrcBotBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Whisnet\IrcBotBundle\Event\DataFromServerEvent;
use Whisnet\IrcBotBundle\Utils\Utils;
use Whisnet\IrcBotBundle\Connection\Socket;

use kosssi\ManagerIrcBotBundle\Entity\IrcServer;

/**
 * @package    ManagerIrcBotBundle
 * @author     Simon Constans <kosssi@gmail.com>
 */
class LaunchBotCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ircbot:launch:server')
            ->setDescription('Launch a irc bot')
            ->addArgument(
                'irc_server_name',
                InputArgument::OPTIONAL,
                'What is the server ?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ircServerName = $input->getArgument('irc_server_name');
        /** @var $server IrcServer */
        $server = $this->getContainer()->get('doctrine')->getRepository('ManagerIrcBotBundle:IrcServer')->findOneByName($ircServerName);

        try {
            $dispatcher = $this->getContainer()->get('event_dispatcher');

            $socket = new Socket($server->getHost(), $server->getPort(), $this->getContainer()->get('validator'), $this->getContainer()->get('event_dispatcher'));
            $socket->connect();

            do {
                $dispatcher->dispatch('whisnet_irc_bot.data_from_server', new DataFromServerEvent(Utils::cleanUpServerRequest($socket->getData())));
            } while (true);
        } catch (Exception $e) {
            $server->setPid(0);
            $em = $this->getContainer()->get('doctrine')->getManager();
            $em->persist($server);
            $em->flush();
        }
    }
}
