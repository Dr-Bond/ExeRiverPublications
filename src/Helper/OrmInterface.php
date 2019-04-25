<?php

namespace App\Helper;

/**
 * Interface OrmInterface
 * @package App\Helper
 */
interface OrmInterface
{
    /**
     * @param $ql
     * @return mixed
     */
    public function createQuery($ql);

    /**
     * @return mixed
     */
    public function createQueryBuilder();

    /**
     * @param $objectClass
     * @return mixed
     */
    public function getRepository($objectClass);

    /**
     * @param $object
     * @return mixed
     */
    public function persist($object);

    /**
     * @param $object
     * @return mixed
     */
    public function remove($object);

    /**
     * @return mixed
     */
    public function flush();

    /**
     * @param $object
     * @param array $criteria
     * @return mixed
     */
    public function find($object, $criteria = array());

    /**
     * @param $object
     * @return mixed
     */
    public function findAll($object);
}