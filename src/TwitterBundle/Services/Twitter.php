<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 10-05-16
 * Time: 02:59
 */

namespace TwitterBundle\Services;


use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

class Twitter
{
    protected $consumer_key = '4uh3Ozf2KMi35IzONBurg';
    protected $consumer_secret = 'QyVXcpfmtWG7PS7JOw9u2qq09HfAuUwv19EWYV0Do';
    protected $token = '523110535-9nVEL6E7z8Gmr1QTiEwxcYaHZKffsZS4J57ciyIV';
    protected $token_secret = 'DExgBowfqBEOjvxTqOlTWZBDU6bXjDd21LYERPTYWePH7';

    protected $client;
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key'    => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret,
            'token'           => $this->token,
            'token_secret'    => $this->token_secret
        ]);
        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack
        ]);
    }

    public function getUserTimeline()
    {
        return $this->client
            ->get('statuses/user_timeline.json', [
                    'auth' => 'oauth'
                ])
            ->getBody()
            ->getContents();
    }

    public function getFarmedTweets()
    {
        $tweetRepo = $this->em->getRepository('TwitterBundle:Tweet');
        $allTweets = $tweetRepo->findAll();

        return $allTweets;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}