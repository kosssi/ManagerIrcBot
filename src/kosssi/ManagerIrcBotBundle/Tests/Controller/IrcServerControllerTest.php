<?php

namespace kosssi\ManagerIrcBotBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IrcServerControllerTest extends WebTestCase
{
    public function testServerList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/irc_server');

        // status page test
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/irc_server', $client->getRequest()->getRequestUri());

        // title
        $this->assertCount(1, $crawler->filter('title:contains("Server list")'));
        $this->assertCount(1, $crawler->filter('h1:contains("Server list")'));

        // link
        $this->assertCount(1, $crawler->filter('a:contains("Add a new server")'));
        $link = $crawler->filter('a:contains("Add a new server")')->link();
        $client->click($link);

        return $client;
    }

    /**
     * @depends testServerList
     */
    public function testAddServer($client)
    {
        $crawler = $client->getCrawler();

        // status page test
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/irc_server/new', $client->getRequest()->getRequestUri());

        // title
        $this->assertCount(1, $crawler->filter('title:contains("Add a new server")'));
        $this->assertCount(1, $crawler->filter('h1:contains("Add a new server")'));

        // form
        $this->assertCount(1, $crawler->filter('button[name=submit]:contains("Add")'));
        $form = $crawler->selectButton('submit')->form();

        // set some values
        $form['irc_server[name]'] = 'freenode';
        $form['irc_server[host]'] = 'irc.freenode.net';
        $form['irc_server[port]'] = '6667';
        $form['irc_server[channels]'] = '#test-irc';

        // submit the form
        $client->submit($form);

        return $client;
    }

    /**
     * @depends testAddServer
     */
    public function testVerficationAddServer($client)
    {
        // status page test
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/irc_server', $client->getRequest()->getRequestUri());

        $this->assertCount(2, $crawler->filter('li'));
        $this->assertCount(1, $crawler->filter('li:not(".legends") .irc_server_name:contains("freenode")'));

        // link
        $this->assertCount(1, $crawler->filter('a:contains("Edit")'));
        $link = $crawler->filter('a:contains("Edit")')->link();
        $client->click($link);

        return $client;
    }

    /**
     * @depends testVerficationAddServer
     */
    public function testEditServer($client)
    {
        $crawler = $client->getCrawler();

        // status page test
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('/irc_server/edit/', $client->getRequest()->getRequestUri());

        // title
        $this->assertCount(1, $crawler->filter('title:contains("Edit server freenode")'));
        $this->assertCount(1, $crawler->filter('h1:contains("Edit server freenode")'));

        // form
        $this->assertCount(1, $crawler->filter('button[name=submit]:contains("Save")'));
        $form = $crawler->selectButton('submit')->form();

        // set some values
        $form['irc_server[name]'] = 'freenode2';
        $form['irc_server[host]'] = 'irc.freenode.net';
        $form['irc_server[port]'] = '6667';
        $form['irc_server[channels]'] = '#test-irc';

        // submit the form
        $client->submit($form);

        return $client;
    }

    /**
     * @depends testEditServer
     */
    public function testVerificationEditServer($client)
    {
        // status page test
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/irc_server', $client->getRequest()->getRequestUri());

        $this->assertCount(2, $crawler->filter('li'));
        $this->assertCount(1, $crawler->filter('li:not(".legends") .irc_server_name:contains("freenode2")'));

        // link
        $this->assertCount(1, $crawler->filter('a:contains("Remove")'));
        $link = $crawler->filter('a:contains("Remove")')->link();
        $client->click($link);

        return $client;
    }

    /**
     * @depends testVerificationEditServer
     */
    public function testRemoveServer($client)
    {
        $crawler = $client->getCrawler();

        // status page test
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/irc_server', $client->getRequest()->getRequestUri());

        $this->assertCount(1, $crawler->filter('li'));

        return $client;
    }
}
