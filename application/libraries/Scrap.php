<?php

use Goutte\Client as WebClient;
use GuzzleHttp\Client as HttpClient;

class Scrap extends WebClient
{
    public function __construct()
    {
        $this->client = new WebClient();
        $guzzleClient = new HttpClient(array(
		    'timeout' => 60,
		));
		$this->client->setClient($guzzleClient);
    }

    public function get($url=null)
    {
    	if($url!=null) {
			$crawler = $this->client->request('GET', $url);
			return $crawler;
		}
    }
}