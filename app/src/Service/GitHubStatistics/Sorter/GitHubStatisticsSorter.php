<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Sorter;

use App\DTO\GitHubStatisticsDTO;
use DateTime;
use Webmozart\Assert\Assert;

class GitHubStatisticsSorter
{
    private const MAX_DATE_INTERVAL_IN_DAYS = '90';

    private const ALIVE_PROJECT = 1.3;
    private const DEAD_PROJECT = 0.7;

    /**
     * @param GitHubStatisticsDTO[] $statistics
     *
     * @return GitHubStatisticsDTO[]
     */
    public function sortByActivity(array $statistics): array
    {
        Assert::allIsInstanceOf($statistics, GitHubStatisticsDTO::class);
        $ratings = [];

        foreach ($statistics as $statisticsDTO) {
            $ratings[] = [
                'rating' => $this->calculateRepositoryRating($statisticsDTO),
                'statisticsDTO' => $statisticsDTO,
            ];
        }

        usort($ratings, function ($record1, $record2) {
            return $record2['rating'] <=> $record1['rating'];
        });

        return array_column($ratings, 'statisticsDTO');
    }

    private function calculateRepositoryRating(GitHubStatisticsDTO $statisticsDTO): int
    {
        $rating = $statisticsDTO->stars + $statisticsDTO->watchers;

        $now = new DateTime();
        $lastReleaseDateTime = new DateTime($statisticsDTO->lastReleaseDate);
        $isProjectAlive = $now->diff($lastReleaseDateTime)->days < self::MAX_DATE_INTERVAL_IN_DAYS;

        $rating = $isProjectAlive ? $rating * self::ALIVE_PROJECT : $rating * self::DEAD_PROJECT;

        return (int)round($rating);
    }
}
