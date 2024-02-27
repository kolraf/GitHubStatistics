<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics;

use App\DTO\GitHubRepositoryCollectionDTO;
use App\DTO\GitHubStatisticsCollectionDTO;
use App\Service\GitHubStatistics\Builder\GitHubStatisticsBuilderDirector;
use App\Service\GitHubStatistics\Sorter\GitHubStatisticsSorter;

class GitHubStatisticsService
{
    public function __construct(
        private readonly GitHubStatisticsBuilderDirector $builderDirector,
        private readonly GitHubStatisticsSorter $sorter
    ) {
    }

    public function getStatisticsCollection(
        GitHubRepositoryCollectionDTO $gitHubRepositoryCollectionDTO
    ): GitHubStatisticsCollectionDTO {
        $statistics = [];

        foreach ($gitHubRepositoryCollectionDTO->repositories as $gitHubRepositoryDTO) {
            $statistics[] = $this->builderDirector->build($gitHubRepositoryDTO);
        }

        return new GitHubStatisticsCollectionDTO(
            $this->sorter->sortByActivity($statistics)
        );
    }
}
