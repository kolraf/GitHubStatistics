<?php

declare(strict_types=1);

namespace App\Service\GitHubStatistics\ValueObject;

use LogicException;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

class GitHubStatisticsUrl
{
    private const ULR_PATTERN = 'https://api.github.com/%s';

    private string $url;

    public function __construct(string $path)
    {
        if (!self::isValid($path)) {
            throw new LogicException(sprintf('Invalid GitHub api path - "%s"', $path));
        }

        $this->url = self::createUrl($path);
    }

    public function getValue(): string
    {
        return $this->url;
    }

    public static function isValid(string $path): bool
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate(
            self::createUrl($path),
            [
                new Url()
            ],
        );

        return count($violations) === 0;
    }

    private static function createUrl(string $path): string
    {
        return sprintf(self::ULR_PATTERN, $path);
    }
}
