<?php

namespace App\Criteria\Blog;

use App\Criteria\Criteria;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\ORM\QueryBuilder;

class BlogWithConfidentiality implements Criteria
{
    /**
     * @var int[] $confidentiality
     */
    private array $confidentiality;

    public function __construct($confidentiality)
    {
        $this->confidentiality = is_array($confidentiality)
            ? $confidentiality
            : [$confidentiality];
    }

    public function apply(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere('b.confidentiality IN (:confidentiality)')
            ->setParameter('confidentiality', $this->confidentiality, ArrayParameterType::INTEGER);
    }
}
