<?php

namespace App\Service\Blog;

use App\Criteria\Blog\BlogWithConfidentiality;
use App\Enum\BlogConfidentiality;
use App\Repository\BlogRepository;

class BlogRepositoryService
{
    public function __construct(
        private readonly BlogRepository $blogRepository
    )
    {
    }

    public function getPublicBlog(array $options = []): array
    {
        $limit = $options['limit'] ?? null;

        $qb = (new BlogWithConfidentiality(BlogConfidentiality::PUBLIC))
            ->apply($this->blogRepository->getBlogQueryBuilder());

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $idsToExclude = $options['exclude'] ?? [];
        if ($idsToExclude) {
            $qb->andWhere('b.id NOT IN (:idsToExclude)')
                ->setParameter('idsToExclude', $idsToExclude);
        }

        // sort by created date
        $qb->orderBy('b.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
