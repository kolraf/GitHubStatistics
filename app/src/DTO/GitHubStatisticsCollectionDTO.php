<?php

declare(strict_types=1);

namespace App\DTO;

use Webmozart\Assert\Assert;

class GitHubStatisticsCollectionDTO
{
    /**
     * @var GitHubStatisticsDTO[]
     */
    public readonly array $statistics;

    /**
     * @param GitHubStatisticsDTO[] $statistics
     */
    public function __construct(
        array $statistics
    ) {
        Assert::allIsInstanceOf($statistics, GitHubStatisticsDTO::class);

        $this->statistics = $statistics;
    }
}
