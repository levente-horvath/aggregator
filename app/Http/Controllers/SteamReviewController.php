<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SteamReviewController extends Controller
{
    protected $redditController;

    public function __construct(RedditController $redditController)
    {
        $this->redditController = $redditController;
    }

    public function index()
    {
        $steamResponse = Http::get('https://store.steampowered.com/appreviews/105600', [
            'json' => 1,
            'filter' => 'recent',
            'language' => 'english',
            'num_per_page' => 10
        ]);

        $redditResponse = $this->redditController->getTerrariaPosts();
        $redditComments = $redditResponse->original;

        if ($steamResponse->successful()) {
            $data = $steamResponse->json();
            return view('steam.reviews', [
                'reviews' => $data['reviews'],
                'summary' => $data['query_summary'],
                'redditComments' => $redditComments
            ]);
        }

        return view('steam.reviews', [
            'reviews' => [],
            'summary' => null,
            'redditComments' => $redditComments,
            'error' => 'Failed to fetch Steam reviews'
        ]);
    }
}
