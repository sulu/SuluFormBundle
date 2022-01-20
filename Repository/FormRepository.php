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
use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Entity\Form;

/**
 * @template-extends EntityRepository<Form>
 */
class FormRepository extends EntityRepository
{
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

        $queryBuilder->setMaxResults(self::getValue($filters, 'limit'))
            ->setFirstResult(self::getValue($filters, 'offset'));

        $queryBuilder->orderBy('form.id');
        $queryBuilder->addOrderBy('field.order');
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /**
     * @param mixed[] $filters
     */
    public function countByFilters(string $locale = null, array $filters = []): int
    {
        $queryBuilder = $this->createQueryBuilder('form');
        $queryBuilder->select($queryBuilder->expr()->count('form.id'));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param mixed[] $data
     * @param mixed $default
     */
    protected static function getValue(array $data, string $key, $default = null): ?int
    {
        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }
}
