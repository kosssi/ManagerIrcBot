<?php

namespace kosssi\ManagerIrcBotBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use kosssi\ManagerIrcBotBundle\Entity\IrcServer;
use kosssi\ManagerIrcBotBundle\Form\Type\IrcServerType;
use Whisnet\IrcBotBundle\Command\BotCommand;

/**
 * @package    ManagerIrcBotBundle
 * @author     Simon Constans <kosssi@gmail.com>
 *
 * @Route("/irc_server")
 */
class IrcServerController extends Controller
{
    /**
     * @Route("", name="irc_server")
     * @Template()
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('ManagerIrcBotBundle:IrcServer');
        $servers = $repository->findAll();

        return array('servers' => $servers);
    }

    /**
     * @Route("/new", name="irc_server_new")
     * @Template()
     */
    public function newAction()
    {
        $ircServer = new IrcServer();
        $form = $this->createForm(new IrcServerType(), $ircServer);
        $request = $this->getRequest();

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ircServer);
                $em->flush();

                return $this->redirect($this->generateUrl('irc_server'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{id}", name="irc_server_edit")
     * @Template()
     */
    public function editAction(IrcServer $ircServer)
    {
        $form = $this->createForm(new IrcServerType(), $ircServer);
        $request = $this->getRequest();

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ircServer);
                $em->flush();

                return $this->redirect($this->generateUrl('irc_server'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/launch/{id}", name="irc_server_launch")
     * @Template()
     */
    public function launchAction(IrcServer $ircServer)
    {
        $commandJob = 'php /home/kosssi/dev/projects/ManagerIrcBot/app/console ircbot:launch:server ' . $ircServer->getName();
        $command = $commandJob.' > /dev/null 2>&1 & echo $!';
        exec($command ,$op);
        $pid = (int)$op[0];

        $ircServer->setPid($pid);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ircServer);
        $em->flush();

        return $this->redirect($this->generateUrl('irc_server'));
    }

    /**
     * @Route("/stop/{id}", name="irc_server_stop")
     * @Template()
     */
    public function stopAction(IrcServer $ircServer)
    {
        $commandJob = 'kill ' . $ircServer->getPid();
        $command = $commandJob.' > /dev/null 2>&1';
        exec($command ,$op);

        $ircServer->setPid(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ircServer);
        $em->flush();

        return $this->redirect($this->generateUrl('irc_server'));
    }

    /**
     * @Route("/remove/{id}", name="irc_server_remove")
     * @Template()
     */
    public function removeAction(IrcServer $ircServer)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($ircServer);
        $em->flush();

        return $this->redirect($this->generateUrl('irc_server'));
    }
}
