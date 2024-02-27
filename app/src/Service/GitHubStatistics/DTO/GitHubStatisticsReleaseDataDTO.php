<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\DTO;

class GitHubStatisticsReleaseDataDTO implements GitHubStatisticsInterface
{
    public function __construct(
        public readonly ?string $lastReleaseDate,
    ) {
    }
}
