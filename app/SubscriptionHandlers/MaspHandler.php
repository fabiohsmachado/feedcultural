<?php

namespace App\SubscriptioHandlers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class MaspHandler
{
    private const BASEURL = 'https://masp.org.br';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle($email)
    {
        $tokenBody = $this->client->request('GET', self::BASEURL . '/agenda')->getBody();
        preg_match('/name="_token" value=".*">/', $tokenBody, $tokenOut);
        $token = substr($tokenOut[0], 21, -2);

        $headers = ['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'];
        $body = '_token=' . $token . '&email=' . $email;
        
        $request = new Request('POST', self::BASEURL . '/newsletters', $headers, $body);
        $response = $this->client->send($request);

        return $response->getStatusCode() == 200;
    }
}
