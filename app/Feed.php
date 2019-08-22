<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Feed
{
    protected $id;
    protected $url;
    protected $email;

    public function __construct($id, $url, $email)
    {
        $this->id = $id;
        $this->url = $url;
        $this->email = $email;
    }

    public function id()
    {
        return $this->id;
    }

    public function url()
    {
        return $this->url;
    }

    public function email()
    {
        return $this->email;
    }

    public static function create(Client $client, $id = "FeedCultural")
    {
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $body = 'name=' . $id;
        $request = new Request('POST', 'https://www.kill-the-newsletter.com/', $headers, $body);

        $body = $client->send($request)->getBody();
        preg_match('/https:\/\/www.kill-the-newsletter.com\/feeds\/.*?\.xml/', $body, $matchURL);
        preg_match('/\:.*?@kill-the-newsletter.com/', $body, $matchEmail);

        return new Feed($id, $matchURL[0], substr($matchEmail[0], 1));
    }
}
