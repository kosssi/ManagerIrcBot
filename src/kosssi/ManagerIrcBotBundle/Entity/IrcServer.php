<?php

namespace kosssi\ManagerIrcBotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * kosssi\ManagerIrcBotBundle\Entity\IrcServer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IrcServer
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string $host
     *
     * @ORM\Column(name="host", type="string", length=255)
     */
    private $host;

    /**
     * @var integer $port
     *
     * @ORM\Column(name="port", type="integer", length=6)
     */
    private $port;

    /**
     * @var integer $pid
     *
     * @ORM\Column(name="pid", type="integer", length=10, nullable=true)
     */
    private $pid;

    /**
     * @var string $channels
     *
     * @ORM\Column(name="channels", type="string", length=255)
     */
    private $channels;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return IrcServer
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return IrcServer
     */
    public function setHost($host)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return IrcServer
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return IrcServer
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set channels
     *
     * @param string $channels
     * @return IrcServer
     */
    public function setChannels($channels)
    {
        $this->channels = $channels;

        return $this;
    }

    /**
     * Get channels
     *
     * @return string
     */
    public function getChannels()
    {
        return $this->channels;
    }
}