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
    }
}
