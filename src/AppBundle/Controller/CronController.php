<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CronController extends Controller
{
    /**
     * @Route("/cron", name="cron_index")
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        echo <<<'EOT'
This is the cron controller for the twitterbot, few of the possible runs are:
/cron: this page
/cron/tweet: randomly tweet a quote
EOT;
        exit;
    }

    /**
     * @Route("/cron/tweet", name="cron_tweet")
     *
     * Random quote from quotes.stormconsultancy.co.uk tweetet with
     * the setup app credentials. Each run means a random tweet will be posted
     * by your setup account with the twitter credentials. .
     */
    public function tweetAcion(Request $request)
    {
        $twitterService = $this->get('twitter.client');
        $quoteClient = new Client();
        $quotes = json_decode($quoteClient->get('http://quotes.stormconsultancy.co.uk/popular.json')
            ->getBody()->getContents());

        $quote = $quotes[rand(0, count($quotes) - 1)];

        $response = $twitterService->tweet($quote->quote);

        print_r($response);

        exit;
    }
}
