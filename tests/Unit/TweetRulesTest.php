<?php

namespace Tests\Unit;

use App\Rules\TweetLink;
use App\Rules\UrlReachable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TweetRulesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTweetLinkRule()
    {
        $properTweetUrl = 'https://twitter.com/testmiller33/status/296238515124072448';
        $inexistingTweetUrl = 'https://twitter.com/testmiller33/status/296238515124099999';
        $profileUrl = 'https://twitter.com/testmiller33/';
        $improperUrl = 'http://i-am-not-twitter.com';
        $improperUrl2 = 'http://i-am-not-twitter.com/testmiller33/status/296238515124072448';
        $improperUrl3 = 'http://i-am-not-twitter.com/testmiller33/status/29623851512407244a';

        $rule = new TweetLink();
        $this->assertTrue(
            $rule->passes('tweetUrl', $properTweetUrl), 'Correct tweet link will pass'
        );

        $this->assertTrue(
            $rule->passes('tweetUrl', $inexistingTweetUrl), 'even if tweet does not exist'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $profileUrl), 'Profile link will not pass'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $improperUrl), 'Random link will not pass'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $improperUrl2), 'even if it tries to mock twitter URL structure'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $improperUrl3), 'Tseet link can not contain letters'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', ''), 'Empty string will not pass'
        );

    }

    public function testUrlReachableRule()
    {
        $reachableUrl = 'https://twitter.com/testmiller33/status/296238515124072448';
        $unreachableUrl = 'https://twitter.com/testmiller33/status/296238515124099999';
        $randomUrl = 'http://i-am-not-twitter.com';

        $rule = new UrlReachable();
        $this->assertTrue(
            $rule->passes('tweetUrl', $reachableUrl), 'Reachable Url passes'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $unreachableUrl), 'Inexisting tweet URL does not pass'
        );

        $this->assertFalse(
            $rule->passes('tweetUrl', $randomUrl), 'One more test with random url'
        );
    }
}
