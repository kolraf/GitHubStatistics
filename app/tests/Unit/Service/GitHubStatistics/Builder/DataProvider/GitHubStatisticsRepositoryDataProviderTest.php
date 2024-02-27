<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GitHubStatistics\Builder\DataProvider;

use App\DTO\GitHubRepositoryDTO;
use App\Service\GitHubStatistics\Builder\DataProvider\GitHubStatisticsRepositoryDataProvider;
use App\Service\GitHubStatistics\Client\GitHubStatisticsClient;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GitHubStatisticsRepositoryDataProviderTest extends TestCase
{
    private GitHubStatisticsClient&MockObject $mockClient;

    private GitHubStatisticsRepositoryDataProvider $dataProvider;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(GitHubStatisticsClient::class);
        $this->dataProvider = new GitHubStatisticsRepositoryDataProvider(
            $this->mockClient,
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @dataProvider correctDataProvider
     */
    public function testCorrectData(array $data): void
    {
        $this->mockClient->method('get')->willReturn($data);
        $response = $this->dataProvider->provide(
            new GitHubRepositoryDTO(
                'userName',
                'repositoryName',
            ),
        );

        self::assertSame((int)$data['stargazers_count'], $response->stars);
        self::assertSame((int)$data['subscribers_count'], $response->watchers);
        self::assertSame((int)$data['forks'], $response->forks);
    }

    /**
     * @param array<string, int> $data
     *
     * @dataProvider incorrectDataProvider
     */
    public function testIncorrectData(array $data, string $missingKey): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage(sprintf('Expected the key "%s" to exist.', $missingKey));

        $this->mockClient->method('get')->willReturn($data);
        $this->dataProvider->provide(
            new GitHubRepositoryDTO(
                'userName',
                'repositoryName',
            ),
        );
    }

    /**
     * @return array<int, mixed>
     */
    public static function correctDataProvider(): array
    {
        return [
            [[
                'stargazers_count' => 1,
                'subscribers_count' => 2,
                'forks' => 3,
            ]],
            [[
                'stargazers_count' => '1',
                'subscribers_count' => '2',
                'forks' => '3',
            ]],
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public static function incorrectDataProvider(): array
    {
        return [
            [
                [
                    'stargazers_count' => 1,
                    'subscribers_count' => 2,
                ],
                'forks',
            ],
            [
                [
                    'stargazers_count' => 1,
                    'forks' => 3,
                ],
                'subscribers_count',
            ],
            [
                [
                    'subscribers_count' => 2,
                    'forks' => 3,
                ],
                'stargazers_count',
            ],
            [
                [],
                'stargazers_count',
            ],
        ];
    }
}
