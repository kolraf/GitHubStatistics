<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\DTO\GitHubStatisticsRepositoryDataDTO;
use App\Service\GitHubStatistics\ValueObject\GitHubStatisticsUrl;
use Webmozart\Assert\Assert;

class GitHubStatisticsRepositoryDataProvider extends GitHubStatisticsAbstractDataProvider
{
    private const PATH_PATTERN = 'repos/%s/%s';

    public function provide(GitHubRepositoryDTO $gitHubRepositoryDTO): GitHubStatisticsRepositoryDataDTO
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::PATH_PATTERN,
                        $gitHubRepositoryDTO->userName,
                        $gitHubRepositoryDTO->repositoryName,
                    )
                )
            );

        Assert::keyExists($response, 'stargazers_count');
        Assert::keyExists($response, 'subscribers_count');
        Assert::keyExists($response, 'forks');

        return new GitHubStatisticsRepositoryDataDTO(
            stars: (int)$response['stargazers_count'],
            watchers: (int)$response['subscribers_count'],
            forks: (int)$response['forks'],
        );
    }
}
