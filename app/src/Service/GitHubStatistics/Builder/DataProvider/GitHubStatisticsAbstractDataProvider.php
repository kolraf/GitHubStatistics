<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\Client\GitHubStatisticsClient;
use App\Service\GitHubStatistics\DTO\GitHubStatisticsInterface;

abstract class GitHubStatisticsAbstractDataProvider
{
    public function __construct(
        protected readonly GitHubStatisticsClient $client
    ) {
    }

    abstract public function provide(GitHubRepositoryDTO $gitHubRepositoryDTO): GitHubStatisticsInterface;
}
