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
        return $this->find($id);
    }

    /**
     * @param string $locale
     * @param array $filters
     *
     * @return Form[]
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
     * @param string $locale
     * @param array $filters
     *
     * @return int
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
