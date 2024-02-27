<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder;

use App\DTO\GitHubRepositoryDTO;
use App\DTO\GitHubStatisticsDTO;

interface GitHubStatisticsBuilderInterface
{
    public function buildRepositoryBasicData(GitHubRepositoryDTO $gitHubRepositoryDTO): self;

    public function buildRepositoryStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self;

    public function buildPullRequestStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self;

    public function buildReleaseStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self;

    public function getAndClearGitHubStatisticsDTO(): GitHubStatisticsDTO;
}
