<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class GitHubRepositoryDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Nazwa użytkownika jest wymagana.')]
        public readonly string $userName,
        #[Assert\NotBlank(message: 'Nazwa repozytorium jest wymagana.')]
        public readonly string $repositoryName,
    ) {
    }
}
