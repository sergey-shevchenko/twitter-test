<?php

namespace App\Http\Middleware;

use App\Rules\TweetExists;
use App\Rules\TweetLink;
use Closure;
use Illuminate\Foundation\Validation\ValidatesRequests;

class GetTweetId
{
    use ValidatesRequests;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->validate($request, [
            'tweetUrl' => ['required', new TweetLink(), new TweetExists()]
        ]);
        $explodedUrl = explode('/', $request->tweetUrl);
        $request->tweetId = array_pop($explodedUrl);
        return $next($request);
    }
}
