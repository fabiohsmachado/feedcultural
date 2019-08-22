<?php

namespace Tests\Unit;

use App\Source;
use Tests\TestCase;

class SourceTest extends TestCase
{
    protected $source;

    public function setUp() : void
    {
        $this->source = new Source("TestSource", "Source Test", MockHandler::class);
    }

    /** @test */
    public function aSourceHasAnId()
    {
        $this->assertEquals("TestSource", $this->source->id());
    }

    /** @test */
    public function aSourceHasAName()
    {
        $this->assertEquals("Source Test", $this->source->name());
    }

    /** @test */
    public function aSourceCanSubscribeAndEmail()
    {
        $this->assertTrue($this->source->subscribe("mockemail@test.com"));
    }
}

class MockHandler
{
    public function handle($email)
    {
        return true;
    }
}