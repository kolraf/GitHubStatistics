<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GitHubStatistics\Builder;

use App\DTO\GitHubRepositoryDTO;
use App\DTO\GitHubStatisticsDTO;
use App\Service\GitHubStatistics\Builder\GitHubStatisticsBuilderDirector;
use App\Service\GitHubStatistics\Builder\GitHubStatisticsBuilderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GitHubStatisticsBuilderDirectorTest extends TestCase
{
    private GitHubStatisticsBuilderInterface&MockObject $mockBuilder;

    private GitHubStatisticsBuilderDirector $director;

    public function setUp(): void
    {
        $this->mockBuilder = $this->createMock(GitHubStatisticsBuilderInterface::class);
        $this->director = new GitHubStatisticsBuilderDirector($this->mockBuilder);
    }

    public function testBuild(): void
    {
        $mockGitHubRepositoryDTO = $this->createMock(GitHubRepositoryDTO::class);
        $mockStatisticsDTO = $this->createMock(GitHubStatisticsDTO::class);

        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildRepositoryBasicData')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildRepositoryStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildPullRequestStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildReleaseStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder->expects($this->exactly(1))->method('getAndClearGitHubStatisticsDTO')
            ->willReturn($mockStatisticsDTO);

        self::assertSame($mockStatisticsDTO, $this->director->build($mockGitHubRepositoryDTO));
    }
}
