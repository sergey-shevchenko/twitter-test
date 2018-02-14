<?php

namespace Tests\Feature;

use App\Http\Middleware\GetTweetId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TweeterControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTwitterController()
    {
        $properTweetUrl = 'https://twitter.com/testmiller33/status/296238515124072448';

        $response = $this->post(route('post.tweetReach'),[
            'tweetUrl' => $properTweetUrl
        ]);
        $response->assertStatus(302);
        $response->assertRedirect();

        $passedTwitterId = '';
        $request = Request::create(route('post.tweetReach'), 'POST', ['tweetUrl' => $properTweetUrl]);
        (new GetTweetId())->handle($request, function($request) use (&$passedTwitterId) {
            $passedTwitterId = $request->tweetId;
        });

        Cache::shouldReceive('remember')
            ->once();
        $response = $this->get(route('get.tweetReach', ['id' => $passedTwitterId]));
        $response->assertStatus(200);
        $response->assertViewHas('reach');

    }
}
