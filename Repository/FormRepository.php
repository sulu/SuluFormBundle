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

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Entity\Form;

/**
 * @template-extends EntityRepository<Form>
 */
class FormRepository extends EntityRepository
{
    /**
     * @param array<int> $ids
     *
     * @return array<Form>
     */
    public function loadByIds(int $ids, ?string $locale = null): array
    {
        $queryBuilder = $this->createQueryBuilder('form')
            ->leftJoin('form.translations', 'translation')->addSelect('translation')
            ->leftJoin('form.fields', 'field')->addSelect('field')
            ->leftJoin('field.translations', 'fieldTranslation')->addSelect('fieldTranslation')
            ->leftJoin('translation.receivers', 'receiver')->addSelect('receiver');

        $queryBuilder->where($queryBuilder->expr()->in('form.id', $ids));
        $queryBuilder->orderBy('field.order');
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function loadById(int $id, ?string $locale = null): ?Form
    {
        $queryBuilder = $this->createQueryBuilder('form')
            ->leftJoin('form.translations', 'translation')->addSelect('translation')
            ->leftJoin('form.fields', 'field')->addSelect('field')
            ->leftJoin('field.translations', 'fieldTranslation')->addSelect('fieldTranslation')
            ->leftJoin('translation.receivers', 'receiver')->addSelect('receiver');

        $queryBuilder->where($queryBuilder->expr()->eq('form.id', ':id'));
        $queryBuilder->setParameter('id', $id);
        $queryBuilder->orderBy('field.order');
        $query = $queryBuilder->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * @param mixed[] $filters
     *
     * @return Form[]
     */
    public function loadAll(?string $locale = null, array $filters = []): array
    {
        $queryBuilder = $this->createQueryBuilder('form')
            ->leftJoin('form.translations', 'translation')->addSelect('translation')
            ->leftJoin('form.fields', 'field')->addSelect('field')
            ->leftJoin('field.translations', 'fieldTranslation')->addSelect('fieldTranslation');

        $queryBuilder->setMaxResults($filters['limit'] ?? null)
            ->setFirstResult($filters['offset'] ?? null);

        $queryBuilder->orderBy('form.id');
        $queryBuilder->addOrderBy('field.order');
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /**
     * @param mixed[] $filters
     */
    public function countByFilters(?string $locale = null, array $filters = []): int
    {
        $queryBuilder = $this->createQueryBuilder('form');
        $queryBuilder->select($queryBuilder->expr()->count('form.id'));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
