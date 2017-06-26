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
        header("Content-Type: text/plain");

        print_r($twitter->getUserTimeline());

        exit;
    }
}
