<?php

namespace App\Helper;

interface OrmInterface
{
    public function createQuery($ql);
    public function createQueryBuilder();
    public function getRepository($objectClass);
    public function persist($object);
    public function remove($object);
    public function flush();
    public function find($object, $criteria = array());
    public function findAll($object);
}