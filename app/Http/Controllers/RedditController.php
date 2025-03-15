<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RedditController extends Controller
{
    private $accessToken;
    
    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $response = Http::withBasicAuth('3RsmWgDsuoO5pA', 't_n-_EMQ8a6-cHl-AuFrOHC3aKRgNg')
            ->asForm()
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'password',
                'username' => 'levente-horvath',
                'password' => 'discordbot123'
            ]);



        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to get Reddit access token');
    }

    public function getTerrariaPosts()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'User-Agent' => 'dsicasdordbot'
            ])->get('https://oauth.reddit.com/search', [
                'q' => 'terraria',
                'limit' => 10,
                'sort' => 'new',
                'type' => 'comment'
            ]);

            if ($response->successful()) {
                $comments = $response->json()['data']['children'];
                $formattedComments = [];

                //dd($comments[0]['data']);

                foreach ($comments as $comment) {
                    $commentData = $comment['data'];
                    $formattedComments[] = [
                        'author' => $commentData['author'],
                        'body' => $commentData['selftext'],
                        'created_utc' => $commentData['created_utc'],
                        'score' => $commentData['score'],
                        'permalink' => 'https://reddit.com' . $commentData['permalink']
                    ];
                }

                return response()->json($formattedComments);
            }

            return response()->json(['error' => 'Failed to fetch Reddit comments'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 