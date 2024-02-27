<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\DTO\GitHubStatisticsReleaseDataDTO;
use App\Service\GitHubStatistics\ValueObject\GitHubStatisticsUrl;

class GitHubStatisticsReleaseDataProvider extends GitHubStatisticsAbstractDataProvider
{
    private const LATEST_RELEASE_PATH_PATTERN = 'repos/%s/%s/releases/latest';

    public function provide(GitHubRepositoryDTO $gitHubRepositoryDTO): GitHubStatisticsReleaseDataDTO
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::LATEST_RELEASE_PATH_PATTERN,
                        $gitHubRepositoryDTO->userName,
                        $gitHubRepositoryDTO->repositoryName,
                    )
                )
            );

        return new GitHubStatisticsReleaseDataDTO(
            lastReleaseDate: $response['published_at'] ?? null,
        );
    }
}
