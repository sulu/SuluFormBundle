<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sulu\Bundle\FormBundle\Entity\Dynamic;

/**
 * Repository for the dynamic entity.
 *
 * @template-extends EntityRepository<Dynamic>
 */
class DynamicRepository extends EntityRepository
{
    /**
     * Finds dynamic entries by the given parameters.
     *
     * @param mixed[] $filters
     * @param string[] $sort
     *
     * @return mixed[]
     */
    public function findByFilters(array $filters, array $sort = [], ?int $limit = null, ?int $offset = null)
    {
        $queryBuilder = $this->createQueryBuilder('dynamic');

        // Add filter.
        $this->addFilter($queryBuilder, $filters);

        // Add sorting.
        if (!empty($sort)) {
            foreach ($sort as $key => $value) {
                $queryBuilder->addOrderBy('dynamic.' . $key, $value);
            }
        }

        // Add limit and offset.
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Returns the number of found entities.
     *
     * @param mixed[] $filters
     */
    public function countByFilters(array $filters): int
    {
        $queryBuilder = $this->createQueryBuilder('dynamic');
        $queryBuilder->select($queryBuilder->expr()->count('dynamic.id'));
        $this->addFilter($queryBuilder, $filters);

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Adds the filters from the given array to the QueryBuilder.
     *
     * @param mixed[] $filters
     */
    protected function addFilter(QueryBuilder $queryBuilder, array $filters): void
    {
        $fromDate = null;
        $toDate = null;
        $search = null;
        $searchFields = null;

        if (isset($filters['fromDate'])) {
            $fromDate = $filters['fromDate'];
            unset($filters['fromDate']);
        }

        if (isset($filters['toDate'])) {
            $toDate = $filters['toDate'];
            unset($filters['toDate']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            unset($filters['search']);
        }

        if (isset($filters['searchFields'])) {
            $searchFields = $filters['searchFields'];
            unset($filters['searchFields']);
        }

        $this->addSearchFilter($queryBuilder, $search, $searchFields);
        $this->addDateRangeFilter($queryBuilder, $fromDate, $toDate);

        $counter = 0;
        foreach ($filters as $key => $value) {
            $queryBuilder->andWhere($queryBuilder->expr()->eq('dynamic.' . $key, ':value' . $counter));
            $queryBuilder->setParameter('value' . $counter, $value);

            ++$counter;
        }
    }

    /**
     * Depending on the given search term, this function filters the result based on search fields.
     *
     * @param string[] $searchFields
     */
    protected function addSearchFilter(QueryBuilder $queryBuilder, ?string $search, ?array $searchFields): void
    {
        if (empty($search) || empty($searchFields)) {
            return;
        }

        $terms = \explode(' ', $search);

        // Search each term in each search field
        foreach ($terms as $counter => $term) {
            $expressions = [];

            foreach ($searchFields as $searchField) {
                $expressions[] = $queryBuilder->expr()->like(
                    'dynamic.' . $searchField,
                    ':searchTerm' . $counter
                );
            }

            $queryBuilder->andWhere(\call_user_func_array([$queryBuilder->expr(), 'orX'], $expressions));
            $queryBuilder->setParameter('searchTerm' . $counter, '%' . $term . '%');
        }
    }

    /**
     * Depending on the given dates, this function filters the result based on the created date.
     */
    protected function addDateRangeFilter(QueryBuilder $queryBuilder, ?string $fromDate, ?string $toDate): void
    {
        if ($fromDate && $toDate) {
            $queryBuilder->andWhere($queryBuilder->expr()->between('dynamic.created', ':fromDate', ':toDate'));
            $queryBuilder->setParameter('fromDate', $fromDate);
            $queryBuilder->setParameter('toDate', $toDate);
        } elseif ($fromDate) {
            $queryBuilder->andWhere($queryBuilder->expr()->gte('dynamic.created', ':fromDate'));
            $queryBuilder->setParameter('fromDate', $fromDate);
        } elseif ($toDate) {
            $queryBuilder->andWhere($queryBuilder->expr()->lte('dynamic.created', ':toDate'));
            $queryBuilder->setParameter('toDate', $toDate);
        }
    }
}
