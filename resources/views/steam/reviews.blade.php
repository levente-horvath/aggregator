<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terraria Reviews & Comments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @else
            @if($summary)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Steam Review Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-gray-600">Total Reviews</p>
                            <p class="text-2xl font-bold">{{ number_format($summary['total_reviews']) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Rating</p>
                            <p class="text-2xl font-bold">{{ $summary['review_score_desc'] }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Positive Reviews</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($summary['total_positive']) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Steam Reviews -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Recent Steam Reviews</h2>
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-600">
                                                Posted {{ \Carbon\Carbon::createFromTimestamp($review['timestamp_created'])->diffForHumans() }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Playtime: {{ round($review['author']['playtime_forever'] / 60) }} hours
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="{{ $review['voted_up'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $review['voted_up'] ? 'Recommended' : 'Not Recommended' }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-gray-800 whitespace-pre-line">{{ $review['review'] }}</p>
                                <div class="mt-4 flex items-center text-sm text-gray-600">
                                    <span class="mr-4">
                                        👍 {{ $review['votes_up'] }}
                                    </span>
                                    <span>
                                        😄 {{ $review['votes_funny'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reddit Comments -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Recent Reddit Comments</h2>
                    <div class="space-y-6">
                        @foreach($redditComments as $comment)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">u/{{ $comment['author'] }}</p>
                                            <p class="text-sm text-gray-600">
                                                Posted {{ \Carbon\Carbon::createFromTimestamp($comment['created_utc'])->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ $comment['permalink'] }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">
                                            View on Reddit
                                        </a>
                                    </div>
                                </div>
                                <p class="text-gray-800 whitespace-pre-line">{{ $comment['body'] }}</p>
                                <div class="mt-4 flex items-center text-sm text-gray-600">
                                    <span class="mr-4">
                                        Score: {{ $comment['score'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html> 