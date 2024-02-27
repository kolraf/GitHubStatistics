<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder;

use App\DTO\GitHubRepositoryDTO;
use App\DTO\GitHubStatisticsDTO;

class GitHubStatisticsBuilderDirector
{
    public function __construct(
        private readonly GitHubStatisticsBuilderInterface $builder
    ) {
    }

    public function build(GitHubRepositoryDTO $gitHubRepositoryDTO): GitHubStatisticsDTO
    {
        $this->builder
            ->buildRepositoryBasicData($gitHubRepositoryDTO)
            ->buildRepositoryStatistics($gitHubRepositoryDTO)
            ->buildPullRequestStatistics($gitHubRepositoryDTO)
            ->buildReleaseStatistics($gitHubRepositoryDTO);

        return $this->builder->getAndClearGitHubStatisticsDTO();
    }
}
