<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\DTO;

class GitHubStatisticsPullRequestDataDTO implements GitHubStatisticsInterface
{
    public function __construct(
        public readonly ?string $lastMergedPullRequestDate,
        public readonly ?string $lastPullRequestDate,
        public readonly int $numberOfClosedPullRequests,
        public readonly int $numberOfOpenPullRequests,
    ) {
    }
}
