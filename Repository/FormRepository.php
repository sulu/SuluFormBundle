<?php

namespace L91\Sulu\Bundle\FormBundle\Repository;

use L91\Sulu\Bundle\FormBundle\Entity\Form;

class FormRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $id
     * @param string $locale
     *
     * @return Form
     */
    public function findById($id, $locale = null)
    {
        $queryBuilder = $this->createQueryBuilder('form')
            ->leftJoin('form.translations', 'translation')->addSelect('translation')
            ->leftJoin('form.fields', 'field')->addSelect('field')
            ->leftJoin('field.translations', 'fieldTranslation')->addSelect('fieldTranslation');

        $queryBuilder->where($queryBuilder->expr()->eq('form.id', $id));
        $queryBuilder->orderBy('field.order');
        $query = $queryBuilder->getQuery();

        return $query->getSingleResult();
    }

    /**
     * @param string $locale
     * @param array $filters
     *
     * @return Form[]
     */
    public function findAll($locale = null, $filters = [])
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
    public function count($locale = null, $filters = [])
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
