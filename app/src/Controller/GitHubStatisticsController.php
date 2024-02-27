<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\GitHubRepositoryCollectionDTO;
use App\DTO\GitHubStatisticsCollectionDTO;
use App\Service\GitHubStatistics\GitHubStatisticsService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsController]
class GitHubStatisticsController
{
    public function __construct(
        private readonly GitHubStatisticsService $gitHubStatisticsService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    #[OA\RequestBody(
        description: 'Repositories to analyze',
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: GitHubRepositoryCollectionDTO::class),
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns a collection of GitHub statistic',
        content: new OA\JsonContent(
            ref: new Model(type: GitHubStatisticsCollectionDTO::class),
            type: 'object'
        ),
    )]
    #[OA\Tag(name: 'GitHub')]
    #[Route('/api/github-statistic', name: 'github-statistic', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] GitHubRepositoryCollectionDTO $gitHubRepositoryCollectionDTO,
    ): JsonResponse {
        return new JsonResponse(
            $this->normalizer->normalize(
                $this->gitHubStatisticsService->getStatisticsCollection($gitHubRepositoryCollectionDTO),
            ),
        );
    }
}
