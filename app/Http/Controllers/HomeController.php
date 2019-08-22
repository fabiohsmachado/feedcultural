<?php

namespace App\Http\Controllers;

use App\Feed;
use App\Source;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    private $httpClient;

    public function __construct(Client $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }
    /**
     * Show the feed home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sourcesList = [
            array("name" => "MASP", "id" => "masp", "handler" => MaspHandler::class)
//            , array("name" => "Japan House", "id" => "japan_house", "handler" => "")
        ];
       
         return view('home', ["sources" => Source::index($sourcesList)]);
    }

    public function create()
    {
        $feed = Feed::create($this->client);

        foreach (Source::index() as $source) {
            $source->subscribe($feed->Email());
        }

        return view('home', ["sources" => Source::index(), 'feed' => $feed]);
    }
}
