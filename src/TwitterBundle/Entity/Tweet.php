<?php

namespace TwitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet
 *
 * @ORM\Table(name="tweet")
 * @ORM\Entity()
 */
class Tweet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="tweet_id", type="integer", nullable=true)
     */
    private $tweetId;

    /**
     * @var array
     *
     * @ORM\Column(name="userdata", type="array", nullable=true)
     */
    private $userdata;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tweet
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Tweet
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set tweetId
     *
     * @param integer $tweetId
     *
     * @return Tweet
     */
    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;

        return $this;
    }

    /**
     * Get tweetId
     *
     * @return int
     */
    public function getTweetId()
    {
        return $this->tweetId;
    }

    /**
     * Set userdata
     *
     * @param array $userdata
     *
     * @return Tweet
     */
    public function setUserdata($userdata)
    {
        $this->userdata = $userdata;

        return $this;
    }

    /**
     * Get userdata
     *
     * @return array
     */
    public function getUserdata()
    {
        return $this->userdata;
    }
}

