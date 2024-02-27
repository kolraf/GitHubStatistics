<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\GitHubRepositoryCollectionDTO;
use App\DTO\GitHubRepositoryDTO;
use PHPUnit\Framework\TestCase;

class GitHubRepositoryCollectionDTOTest extends TestCase
{
    public function testValues(): void
    {
        $dto1 = new GitHubRepositoryDTO('userName1', 'repositoryName1');
        $dto2 = new GitHubRepositoryDTO('userName2', 'repositoryName2');

        $repositoryCollectionDTO = new GitHubRepositoryCollectionDTO([$dto1, $dto2]);

        self::assertCount(2, $repositoryCollectionDTO->repositories);
        self::assertSame($dto1, $repositoryCollectionDTO->repositories[0]);
        self::assertSame($dto2, $repositoryCollectionDTO->repositories[1]);
    }
}
