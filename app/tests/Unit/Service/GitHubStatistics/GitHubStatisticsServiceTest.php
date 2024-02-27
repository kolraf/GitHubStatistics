<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GitHubStatistics;

use App\DTO\GitHubRepositoryCollectionDTO;
use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\Builder\GitHubStatisticsBuilderDirector;
use App\Service\GitHubStatistics\GitHubStatisticsService;
use App\Service\GitHubStatistics\Sorter\GitHubStatisticsSorter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GitHubStatisticsServiceTest extends TestCase
{
    private GitHubStatisticsBuilderDirector&MockObject $mockDirector;
    private GitHubStatisticsSorter&MockObject $mockSorter;

    private GitHubStatisticsService $service;

    protected function setUp(): void
    {
        $this->mockDirector = $this->createMock(GitHubStatisticsBuilderDirector::class);
        $this->mockSorter = $this->createMock(GitHubStatisticsSorter::class);
        $this->service = new GitHubStatisticsService($this->mockDirector, $this->mockSorter);
    }

    public function testForOneRepository(): void
    {
        $repositoryDTO1 = $this->createMock(GitHubRepositoryDTO::class);
        $gitHubRepositoriesDTO = new GitHubRepositoryCollectionDTO([$repositoryDTO1]);

        $this->mockDirector->expects($this->exactly(1))->method('build');
        $this->mockSorter->expects($this->exactly(1))->method('sortByActivity')->willReturn([]);

        $this->service->getStatisticsCollection($gitHubRepositoriesDTO);
    }

    public function testForManyRepositories(): void
    {
        $repositoryDTO1 = $this->createMock(GitHubRepositoryDTO::class);
        $repositoryDTO2 = $this->createMock(GitHubRepositoryDTO::class);
        $gitHubRepositoriesDTO = new GitHubRepositoryCollectionDTO([$repositoryDTO1, $repositoryDTO2]);

        $this->mockDirector->expects($this->exactly(2))->method('build');
        $this->mockSorter->expects($this->exactly(1))->method('sortByActivity')->willReturn([]);

        $this->service->getStatisticsCollection($gitHubRepositoriesDTO);
    }
}
