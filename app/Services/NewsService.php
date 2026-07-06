<?php

namespace App\Services;

use App\Models\NewsArticle;
use App\Models\NewsSentiment;
use Illuminate\Support\Facades\Http;

class NewsService
{
    private array $keywords = [
        'logistics',
        'shipping',
        'trade',
        'economy',

    ];

    public function syncNews(): int
{
    $count = 0;

    foreach ($this->keywords as $keyword) {

        try {

            $response = Http::timeout(60)
                ->retry(3, 2000)
                ->get(
                    'https://gnews.io/api/v4/search',
                    [
                        'q' => $keyword,
                        'lang' => 'en',
                        'max' => 10,
                        'apikey' => config('services.gnews.key'),
                    ]
                );

            if (! $response->successful()) {

                logger()->warning(
                    'GNews request failed',
                    [
                        'keyword' => $keyword,
                        'status' => $response->status(),
                    ]
                );

                continue;
            }

            $articles =
                $response->json('articles', []);

            foreach ($articles as $article) {

                $news = NewsArticle::updateOrCreate(
                    [
                        'article_url' =>
                            $article['url'],
                    ],
                    [
                        'country_id' => null,

                        'title' =>
                            $article['title'] ?? null,

                        'description' =>
                            $article['description'] ?? null,

                        'source_name' =>
                            $article['source']['name'] ?? null,

                        'source_url' =>
                            $article['source']['url'] ?? null,

                        'image_url' =>
                            $article['image'] ?? null,

                        'category' =>
                            $keyword,

                        'published_at' =>
                            $article['publishedAt'] ?? now(),

                        'api_last_synced_at' =>
                            now(),
                    ]
                );

                $this->analyzeSentiment($news);

                $count++;
            }

        } catch (\Exception $e) {

            logger()->error(
                'GNews sync failed',
                [
                    'keyword' => $keyword,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }

    return $count;

    }

    private function analyzeSentiment(
        NewsArticle $article
    ): void
    {
        $positiveWords = [
            'growth',
            'increase',
            'profit',
            'stable',
            'improve',
            'improved',
            'recovery',
            'recover',
            'expansion',
            'boost',
            'strong',
            'positive',
            'gain',
            'success',
            'development',
        ];

        $negativeWords = [
            'war',
            'crisis',
            'inflation',
            'delay',
            'delays',
            'disaster',
            'conflict',
            'recession',
            'collapse',
            'sanction',
            'risk',
            'shortage',
            'decline',
            'decrease',
            'loss',
            'negative',
            'strike',
            'disruption',
        ];

        $text = strtolower(
            ($article->title ?? '') . ' ' .
            ($article->description ?? '')
        );

        $words = preg_split(
            '/\s+/',
            $text
        );

        $positiveScore = 0;
        $negativeScore = 0;

        foreach ($words as $word) {

            $word = preg_replace(
                '/[^a-z]/',
                '',
                $word
            );

            if (empty($word)) {
                continue;
            }

            if (
                in_array(
                    $word,
                    $positiveWords
                )
            ) {
                $positiveScore++;
            }

            if (
                in_array(
                    $word,
                    $negativeWords
                )
            ) {
                $negativeScore++;
            }
        }

        $neutralScore = max(
            0,
            count($words)
            -
            $positiveScore
            -
            $negativeScore
        );

        $sentiment = 'Neutral';

        if ($positiveScore > $negativeScore) {
            $sentiment = 'Positive';
        }

        if ($negativeScore > $positiveScore) {
            $sentiment = 'Negative';
        }

        $sentimentScore =
            $positiveScore - $negativeScore;

        NewsSentiment::updateOrCreate(
            [
                'article_id' =>
                    $article->id,
            ],
            [
                'positive_score' =>
                    $positiveScore,

                'negative_score' =>
                    $negativeScore,

                'neutral_score' =>
                    $neutralScore,

                'sentiment' =>
                    $sentiment,

                'sentiment_score' =>
                    $sentimentScore,

                'analyzed_at' =>
                    now(),
            ]
        );
    }
}