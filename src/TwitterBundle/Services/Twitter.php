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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Twitter
{
    protected $client;
    /**
     * @var EntityManager
     */
    private $em;

	/**
	 * Twitter constructor.
	 *
	 * @param EntityManager           $entityManager
	 * @param ContainerAwareInterface $container
	 */
	public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->container = $container;

        $stack = HandlerStack::create();

        if(!$this->container->getParameter('consumer_key')){
            $consumer_key = getenv('consumer_key');
            $consumer_secret = getenv('consumer_secret');
            $token = getenv('token');
            $token_secret = getenv('token_secret');
        } else{
            $consumer_key = $this->container->getParameter('consumer_key');
            $consumer_secret = $this->container->getParameter('consumer_secret');
            $token = $this->container->getParameter('token');
            $token_secret = $this->container->getParameter('token_secret');
        }

        $middleware = new Oauth1([
            'consumer_key'    => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'token'           => $token,
            'token_secret'    => $token_secret
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

        if(count($allTweets) == 0){
            return 'Sorry, you have to fill up the tweet table with some tweets to post them. ';
        }

        return $allTweets;
    }

    public function tweet($status = "Tweeting with my own Symfony3 twitterbot! Gitub: https://goo.gl/znZQ7G #symfony3 #guzzleHttp #twitterBundle")
    {
        return $this->client->post('statuses/update.json', [
            'auth' => 'oauth',
            'form_params' => [
                'status' => $status
            ]
        ])
        ->getBody()
        ->getContents();
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