<?php

namespace App\Criteria;

use Doctrine\ORM\QueryBuilder;

interface Criteria
{
    public function apply(QueryBuilder $queryBuilder): QueryBuilder;
}
