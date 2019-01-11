<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Repository;

use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Entity\Form;

class FormRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $id
     * @param string $locale
     *
     * @return Form|null
     */
    public function loadById($id, $locale = null)
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
     * @param string $locale
     * @param array $filters
     *
     * @return Form[]
     */
    public function loadAll($locale = null, $filters = [])
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
     * @param string $locale
     * @param array $filters
     *
     * @return int
     */
    public function countByFilters($locale = null, $filters = [])
    {
        $queryBuilder = $this->createQueryBuilder('form');
        $queryBuilder->select($queryBuilder->expr()->count('form.id'));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $default
     *
     * @return int|null
     */
    protected static function getValue($data, $key, $default = null)
    {
        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }
}
