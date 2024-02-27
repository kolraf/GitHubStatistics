<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class GitHubRepositoryCollectionDTO
{
    /**
     * @param GitHubRepositoryDTO[] $repositories
     */
    public function __construct(
        #[Assert\Count(min: 1, max: 5)]
        public readonly array $repositories
    ) {
    }
}
