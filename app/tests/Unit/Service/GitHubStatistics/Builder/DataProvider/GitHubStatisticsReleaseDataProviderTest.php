<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\Builder\DataProvider\GitHubStatisticsReleaseDataProvider;
use App\Service\GitHubStatistics\Client\GitHubStatisticsClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GitHubStatisticsReleaseDataProviderTest extends TestCase
{
    private GitHubStatisticsClient&MockObject $mockClient;

    private GitHubStatisticsReleaseDataProvider $dataProvider;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(GitHubStatisticsClient::class);
        $this->dataProvider = new GitHubStatisticsReleaseDataProvider(
            $this->mockClient,
        );
    }

    /**
     * @param array<string, string> $data
     *
     * @dataProvider correctDataProvider
     */
    public function testCorrectData(array $data, ?string $expectedValue): void
    {
        $this->mockClient->method('get')->willReturn($data);
        $response = $this->dataProvider->provide(
            new GitHubRepositoryDTO(
                'userName',
                'repositoryName',
            ),
        );

        self::assertSame($expectedValue, $response->lastReleaseDate);
    }

    /**
     * @return array<int, mixed>
     */
    public static function correctDataProvider(): array
    {
        return [
            [
                [
                    'published_at' => '2023-01-01 11:00:00',
                ],
                '2023-01-01 11:00:00',
            ],
            [
                [],
                null,
            ],
        ];
    }
}
