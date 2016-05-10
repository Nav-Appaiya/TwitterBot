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
    protected $consumer_key = 'lc0zla2QvzPtTzcBMF566fwQL';
    protected $consumer_secret = 'qng0UV7zCnxWutSVAhcVhUK9J8hT85dQspf8k0k6cJTMmrBUNs';
    protected $token = '523110535-2Rdah062HqhpHPtbUeGr56TSfn9wxZWGOUSYRhMG';
    protected $token_secret = 'E8twPMbGcV9OgHy5ZYfCm7vnKmw5GffoAmjSKnLalSRTT';

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
}