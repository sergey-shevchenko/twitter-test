<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use Cache;

class TwitterController extends Controller
{
    public function actionTweetReach(Request $request)
    {
        return redirect()->route('get.tweetReach', ['id' => $request->tweetId]);
    }

    public function actionReachView($id)
    {
        $reach = Cache::remember("reach_{$id}", 120, function() use ($id) {
            return $this->getReach($id);
        });

        return view('reach', compact('reach'));
    }

    private function getReach($tweetId)
    {
        $reach = 0;
        try{
            $retweets = Twitter::getRts($tweetId);
        } catch(\RuntimeException $e) {
            if(404 === $e->getCode()) {
                return false;
            }
        }
        foreach($retweets as $retweet) {
            $reach += $retweet->user->followers_count;
            if($retweet->retweet_count > 0) {
                $reach += $this->getReach($retweet->id);
            }
        }

        return $reach;
    }
}
