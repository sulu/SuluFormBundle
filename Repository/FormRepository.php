<?php

namespace L91\Sulu\Bundle\FormBundle\Repository;

class FormRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function findById($id, $locale = null)
    {
        return $this->find($id);
    }

    /**
     * When overwrite this method its recommended to create an own count method.
     *
     * {@inheritdoc}
     */
    public function findAll($locale = null, $filters = [])
    {
        return $this->findBy(
            [],
            ['id' => 'asc'],
            self::getValue($filters, 'limit'),
            self::getValue($filters, 'offset')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function count($locale = null, $filters = [])
    {
        return count($this->findAll($locale, $filters));
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
