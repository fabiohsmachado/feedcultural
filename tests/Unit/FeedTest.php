<?php

namespace Tests\Unit;

use App\Feed;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class FeedTest extends TestCase
{
    protected $feed;

    public function setUp() : void
    {
        $this->feed = new Feed("FeedCultural", "someurl.xml", "someemail@test.com");
    }
    
    /** @test */
    public function aFeedHasAnId()
    {
        $this->assertEquals("FeedCultural", $this->feed->id());
    }

    /** @test */
    public function aFeedHasAURL()
    {
        $this->assertEquals("someurl.xml", $this->feed->url());
    }

    /** @test */
    public function aFeedHasAnEmail()
    {
        $this->assertEquals("someemail@test.com", $this->feed->email());
    }

    /** @test */
    public function aNewFeedCanBeGenerated()
    {
        $responseContent = <<<EOT
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="author" content="Leandro Facchinetti">
            <meta name="description" content="Convert email newsletters into Atom feeds.">
            <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
            <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
            <link rel="icon" type="image/x-icon" href="/favicon.ico">
            <link rel="stylesheet" type="text/css" href="/stylesheets/main.css">
            <title>Kill the Newsletter!</title>
        </head>
        
        <body>
            <header>
                <h1><a href="/"><img alt="Kill the Newsletter!" src="/logo.png" width="300"></a></h1>
                <p>Convert email newsletters into Atom feeds</p>
            </header>
            <main>
                <h1>“JapanHouse” Inbox Created</h1>
        
                <p>
                    Sign up for the newsletter with<br>
                    <a href="mailto:nrxcdtmqpkgzdt4qlwxc@kill-the-newsletter.com"
                        class="copiable">nrxcdtmqpkgzdt4qlwxc@kill-the-newsletter.com</a>
                </p>
        
                <p>
                    Subscribe to the Atom feed at<br>
                    <a href="https://www.kill-the-newsletter.com/feeds/nrxcdtmqpkgzdt4qlwxc.xml" target="_blank"
                        class="copiable">https://www.kill-the-newsletter.com/feeds/nrxcdtmqpkgzdt4qlwxc.xml</a>
                </p>
        
                <p>
                    Don’t share these addresses.<br>
          They contain a security token that other people could use<br>
          to send you spam and to control your newsletter subscriptions.
        </p>
        
                    <p>Enjoy your readings!</p>
        
                    <p><a href="https://www.kill-the-newsletter.com" class="button">Create Another Inbox</a></p>
            </main>
            <footer>
                <p>
                    By <a href="https://www.leafac.com">Leandro Facchinetti</a> ·
                    <a href="https://github.com/leafac/www.kill-the-newsletter.com">Source</a> ·
                    <a href="mailto:kill-the-newsletter@leafac.com">Report an Issue</a>
                </p>
            </footer>
            <script src="/javascripts/copiable.js"></script>
        </body>
        
        </html>
EOT;

        $mockHandler = HandlerStack::create(
            new MockHandler(
                [
                    new Response(200, [], $responseContent)
                ]
            )
        );
        $feed = Feed::create(new Client(['handler' => $mockHandler]));

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('https://www.kill-the-newsletter.com/feeds/nrxcdtmqpkgzdt4qlwxc.xml', $feed->url());
    }
}
