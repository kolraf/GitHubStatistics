<?php

declare(strict_types=1);

namespace App\DTO;

class GitHubStatisticsDTO
{
    public function __construct(
        public ?string $userName = null,
        public ?string $repositoryName = null,
        public ?string $url = null,
        public ?int $forks = null,
        public ?int $stars = null,
        public ?int $watchers = null,
        public ?string $lastPullRequestDate = null,
        public ?string $lastReleaseDate = null,
        public ?string $lastMergedPullRequestDate = null,
        public ?int $numberOfClosedPullRequests = null,
        public ?int $numberOfOpenPullRequests = null
    ) {
    }
}
