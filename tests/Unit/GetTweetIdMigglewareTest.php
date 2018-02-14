<?php

namespace Tests\Unit;

use App\Http\Middleware\GetTweetId;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTweetIdMigglewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTwitterGetIdMiddleware()
    {
        $properTwitterUrl = 'https://twitter.com/testmiller33/status/296238515124072448';
        $properTwitterId = '296238515124072448';
        $request = Request::create(route('post.tweetReach'), 'POST', ['tweetUrl' => $properTwitterUrl]);
        $passedTwitterId = '';
        $middleware = new GetTweetId();
        $middleware->handle($request, function($request) use (&$passedTwitterId) {
            $passedTwitterId = $request->tweetId;
        });
        $this->assertTrue(true);
        $this->assertEquals($properTwitterId, $passedTwitterId, 'Tweet ID calculated correctly');
    }
}
