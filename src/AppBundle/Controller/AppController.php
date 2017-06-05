<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @Route("/", name="app_home")
     */
    public function indexAction(Request $request)
    {
        $twitter = $this->get('twitter.client');
        echo '<pre>';

        print_r(json_decode($twitter->getUserTimeline()));

        exit;
    }

    /**
     * @Route("/tweet", name="app_tweet")
     */
    public function tweetAction(Request $request)
    {
        $twitter = $this->get('twitter.client');
        $client = $twitter->getClient();

        echo '<pre>';

        print_r($twitter->getClient()->);

        exit;
    }
}
