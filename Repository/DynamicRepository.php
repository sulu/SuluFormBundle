<?php

namespace Sulu\Bundle\FormBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository for the dynamic entity.
 */
class DynamicRepository extends EntityRepository
{
    /**
     * Finds dynamic entries by the given parameters.
     *
     * @param array $filters
     * @param array $sort
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findByFilters($filters, $sort = [], $limit = null, $offset = null)
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
     * @param array $filters
     *
     * @return int
     */
    public function countByFilters($filters)
    {
        $queryBuilder = $this->createQueryBuilder('dynamic');
        $queryBuilder->select($queryBuilder->expr()->count('dynamic.id'));
        $this->addFilter($queryBuilder, $filters);

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Adds the filters from the given array to the QueryBuilder.
     *
     * @param QueryBuilder $queryBuilder
     * @param array $filters
     */
    protected function addFilter($queryBuilder, $filters)
    {
        $fromDate = null;
        $toDate = null;

        if (isset($filters['fromDate'])) {
            $fromDate = $filters['fromDate'];
            unset($filters['fromDate']);
        }

        if (isset($filters['toDate'])) {
            $toDate = $filters['toDate'];
            unset($filters['toDate']);
        }

        $this->addDateRangeFilter($queryBuilder, $fromDate, $toDate);

        $counter = 0;
        foreach ($filters as $key => $value) {
            $queryBuilder->andWhere($queryBuilder->expr()->eq('dynamic.' . $key, ':value' . $counter));
            $queryBuilder->setParameter('value' . $counter, $value);

            ++$counter;
        }
    }

    /**
     * Depending on the given dates, this function filters the result based on the created date.
     *
     * @param QueryBuilder $queryBuilder
     * @param string $fromDate
     * @param string $toDate
     */
    protected function addDateRangeFilter($queryBuilder, $fromDate, $toDate)
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
