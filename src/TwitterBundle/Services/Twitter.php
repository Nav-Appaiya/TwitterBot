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
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

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
        $middleware = new Oauth1([
            'consumer_key'    => $this->container->getParameter('consumer_key'),
            'consumer_secret' => $this->container->getParameter('consumer_secret'),
            'token'           => $this->container->getParameter('token'),
            'token_secret'    => $this->container->getParameter('token_secret')
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
}