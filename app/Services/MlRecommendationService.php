<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MlRecommendationService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ML_SERVICE_URL', 'http://127.0.0.1:8001');
    }

    protected function get(string $endpoint, array $params = [])
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}{$endpoint}", $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service request failed", [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error("ML Service connection error", [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    protected function post(string $endpoint, array $data = [])
    {
        try {
            $response = Http::timeout(5)->post("{$this->baseUrl}{$endpoint}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service POST request failed", [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error("ML Service connection error", [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    public function getPopularWisata(int $limit = 5): ?array
    {
        $result = $this->get('/api/v1/wisata/popular', ['limit' => $limit]);

        return $result['data'] ?? null;
    }

    public function getPopularKuliner(int $limit = 5): ?array
    {
        $result = $this->get('/api/v1/kuliner/popular', ['limit' => $limit]);

        return $result['data'] ?? null;
    }

    public function recommendWisata(int $userId, ?string $kategori = null, ?int $budgetMin = null, ?int $budgetMax = null, ?float $ratingMin = null, int $topN = 5): ?array
    {
        $data = [
            'user_id' => $userId,
            'top_n' => $topN
        ];

        if ($kategori) $data['kategori'] = $kategori;
        if ($budgetMin !== null) $data['budget_min'] = $budgetMin;
        if ($budgetMax !== null) $data['budget_max'] = $budgetMax;
        if ($ratingMin !== null) $data['rating_min'] = $ratingMin;

        $result = $this->post('/api/v1/wisata/recommend', $data);

        return $result['data'] ?? null;
    }

    public function recommendKuliner(int $userId, ?string $kategori = null, ?int $budgetMin = null, ?int $budgetMax = null, ?float $ratingMin = null, int $topN = 5): ?array
    {
        $data = [
            'user_id' => $userId,
            'top_n' => $topN
        ];

        if ($kategori) $data['kategori'] = $kategori;
        if ($budgetMin !== null) $data['budget_min'] = $budgetMin;
        if ($budgetMax !== null) $data['budget_max'] = $budgetMax;
        if ($ratingMin !== null) $data['rating_min'] = $ratingMin;

        $result = $this->post('/api/v1/kuliner/recommend', $data);

        return $result['data'] ?? null;
    }

    public function rateWisata(int $wisataId, int $userId, float $rating): bool
    {
        $result = $this->post('/api/v1/wisata/rate', [
            'wisata_id' => $wisataId,
            'user_id' => $userId,
            'rating' => $rating
        ]);

        return $result['success'] ?? false;
    }

    public function rateKuliner(int $kulinerId, int $userId, float $rating): bool
    {
        $result = $this->post('/api/v1/kuliner/rate', [
            'kuliner_id' => $kulinerId,
            'user_id' => $userId,
            'rating' => $rating
        ]);

        return $result['success'] ?? false;
    }
}
