<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\DTO\GitHubStatisticsPullRequestDataDTO;
use App\Service\GitHubStatistics\ValueObject\GitHubStatisticsUrl;
use Webmozart\Assert\Assert;

class GitHubStatisticsPullRequestDataProvider extends GitHubStatisticsAbstractDataProvider
{
    private const LAST_PULL_REQUEST_PATH_PATTERN = 'repos/%s/%s/pulls?sort=created&direction=desc&page=1&per_page=1';
    private const LAST_MERGED_PULL_REQUEST_PATH_PATTERN =
        'search/commits?q=repo:%s/%s+merge:true&sort=committer-date&per_page=1&page=1';
    private const CLOSED_PULL_REQUEST_PATH_PATTERN = 'search/issues?q=repo:%s/%s+is:pr+is:closed&per_page=1';
    private const OPEN_PULL_REQUEST_PATH_PATTERN = 'search/issues?q=repo:%s/%s+is:pr+is:open&per_page=1';

    public function provide(GitHubRepositoryDTO $gitHubRepositoryDTO): GitHubStatisticsPullRequestDataDTO
    {
        return new GitHubStatisticsPullRequestDataDTO(
            lastMergedPullRequestDate: $this->getLastMergedPullRequestDate($gitHubRepositoryDTO),
            lastPullRequestDate: $this->getLastPullRequestDate($gitHubRepositoryDTO),
            numberOfClosedPullRequests: $this->getNumberOfClosedPullRequests($gitHubRepositoryDTO),
            numberOfOpenPullRequests: $this->getNumberOfOpenPullRequests($gitHubRepositoryDTO),
        );
    }

    private function getLastMergedPullRequestDate(GitHubRepositoryDTO $gitHubRepositoryDto): ?string
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::LAST_MERGED_PULL_REQUEST_PATH_PATTERN,
                        $gitHubRepositoryDto->userName,
                        $gitHubRepositoryDto->repositoryName,
                    )
                )
            );

        return $response['items'][0]['commit']['committer']['date'] ?? null;
    }

    private function getLastPullRequestDate(GitHubRepositoryDTO $gitHubRepositoryDto): ?string
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::LAST_PULL_REQUEST_PATH_PATTERN,
                        $gitHubRepositoryDto->userName,
                        $gitHubRepositoryDto->repositoryName,
                    )
                )
            );

        return $response[0]['created_at'] ?? null;
    }

    private function getNumberOfClosedPullRequests(GitHubRepositoryDTO $gitHubRepositoryDto): int
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::CLOSED_PULL_REQUEST_PATH_PATTERN,
                        $gitHubRepositoryDto->userName,
                        $gitHubRepositoryDto->repositoryName,
                    )
                )
            );

        Assert::keyExists($response, 'total_count');

        return (int)$response['total_count'];
    }

    private function getNumberOfOpenPullRequests(GitHubRepositoryDTO $gitHubRepositoryDto): int
    {
        $response = $this->client
            ->get(
                new GitHubStatisticsUrl(
                    sprintf(
                        self::OPEN_PULL_REQUEST_PATH_PATTERN,
                        $gitHubRepositoryDto->userName,
                        $gitHubRepositoryDto->repositoryName,
                    )
                )
            );

        Assert::keyExists($response, 'total_count');

        return (int)$response['total_count'];
    }
}
