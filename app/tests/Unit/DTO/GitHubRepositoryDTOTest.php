<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\GitHubRepositoryDTO;
use PHPUnit\Framework\TestCase;

class GitHubRepositoryDTOTest extends TestCase
{
    public function testValues(): void
    {
        $userName = 'userName';
        $repositoryName = 'repositoryName';

        $repositoryDTO = new GitHubRepositoryDTO($userName, $repositoryName);

        self::assertSame($repositoryDTO->userName, $userName);
        self::assertSame($repositoryDTO->repositoryName, $repositoryName);
    }
}
