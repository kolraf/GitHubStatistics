<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\DTO;

class GitHubStatisticsRepositoryDataDTO implements GitHubStatisticsInterface
{
    public function __construct(
        public readonly int $stars,
        public readonly int $watchers,
        public readonly int $forks,
    ) {
    }
}
