<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\Builder;

use App\DTO\GitHubRepositoryDTO;
use App\DTO\GitHubStatisticsDTO;
use App\Service\GitHubStatistics\Builder\DataProvider\GitHubStatisticsPullRequestDataProvider;
use App\Service\GitHubStatistics\Builder\DataProvider\GitHubStatisticsReleaseDataProvider;
use App\Service\GitHubStatistics\Builder\DataProvider\GitHubStatisticsRepositoryDataProvider;

class GitHubStatisticsBuilder implements GitHubStatisticsBuilderInterface
{
    private const URL_PATTERN = 'https://github.com/%s/%s';

    private GitHubStatisticsDTO $gitHubStatisticsDTO;

    public function __construct(
        private readonly GitHubStatisticsRepositoryDataProvider $repositoryDataProvider,
        private readonly GitHubStatisticsPullRequestDataProvider $pullRequestDataProvider,
        private readonly GitHubStatisticsReleaseDataProvider $releaseDataProvider,
    ) {
        $this->gitHubStatisticsDTO = new GitHubStatisticsDTO();
    }

    public function buildRepositoryBasicData(GitHubRepositoryDTO $gitHubRepositoryDTO): self
    {
        $this->gitHubStatisticsDTO->userName = $gitHubRepositoryDTO->userName;
        $this->gitHubStatisticsDTO->repositoryName = $gitHubRepositoryDTO->repositoryName;
        $this->gitHubStatisticsDTO->url = sprintf(
            self::URL_PATTERN,
            $gitHubRepositoryDTO->userName,
            $gitHubRepositoryDTO->repositoryName,
        );

        return $this;
    }

    public function buildRepositoryStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self
    {
        $gitHubRepositoryStats = $this->repositoryDataProvider->provide($gitHubRepositoryDTO);

        $this->gitHubStatisticsDTO->stars = $gitHubRepositoryStats->stars;
        $this->gitHubStatisticsDTO->watchers = $gitHubRepositoryStats->watchers;
        $this->gitHubStatisticsDTO->forks = $gitHubRepositoryStats->forks;

        return $this;
    }

    public function buildPullRequestStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self
    {
        $gitHubPullRequestStats = $this->pullRequestDataProvider->provide($gitHubRepositoryDTO);

        $this->gitHubStatisticsDTO->lastPullRequestDate = $gitHubPullRequestStats->lastPullRequestDate;
        $this->gitHubStatisticsDTO->lastMergedPullRequestDate = $gitHubPullRequestStats->lastMergedPullRequestDate;
        $this->gitHubStatisticsDTO->numberOfClosedPullRequests = $gitHubPullRequestStats->numberOfClosedPullRequests;
        $this->gitHubStatisticsDTO->numberOfOpenPullRequests = $gitHubPullRequestStats->numberOfOpenPullRequests;

        return $this;
    }

    public function buildReleaseStatistics(GitHubRepositoryDTO $gitHubRepositoryDTO): self
    {
        $gitHubReleaseStats = $this->releaseDataProvider->provide($gitHubRepositoryDTO);

        $this->gitHubStatisticsDTO->lastReleaseDate = $gitHubReleaseStats->lastReleaseDate;

        return $this;
    }

    public function getAndClearGitHubStatisticsDTO(): GitHubStatisticsDTO
    {
        $gitHubStatisticsDTO = clone $this->gitHubStatisticsDTO;
        $this->gitHubStatisticsDTO = new GitHubStatisticsDTO();

        return $gitHubStatisticsDTO;
    }
}
