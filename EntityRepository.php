<?php

namespace XM;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Abstract Class EntityRepository
 * The idea is taken from:
 * https://blog.fervo.se/blog/2017/07/06/doctrine-repositories-autowiring/
 *
 * @package XM
 */
abstract class EntityRepository
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * The entity class name.
     * Must be set / defined when extending.
     * @var string
     */
    protected $class;

    /**
     * EntityRepository constructor.
     *
     * @param ManagerRegistry $managerRegistry
     *
     * @throws \RuntimeException
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;

        if (!class_exists($this->class)) {
            throw new \RuntimeException(
                sprintf('The class must be set on the entity repository: %s', get_class($this))
            );
        }
    }

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy
     *
     * @return \Doctrine\ORM\QueryBuilder
     *
     * @see \Doctrine\ORM\EntityRepository::createQueryBuilder()
     */
    public function createQueryBuilder(
        $alias,
        $indexBy = null
    ): \Doctrine\ORM\QueryBuilder {
        return $this->getRepository()
            ->createQueryBuilder($alias, $indexBy);
    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed $id
     *
     * @return object|null
     *
     * @see \Doctrine\ORM\EntityRepository::find()
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Finds all entities in the repository.
     *
     * @return array
     *
     * @see \Doctrine\ORM\EntityRepository::findAll()
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array
     *
     * @see \Doctrine\ORM\EntityRepository::findBy()
     */
    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        return $this->getRepository()
            ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     *
     * @see \Doctrine\ORM\EntityRepository::findOneBy()
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * Adds support for magic finders.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return array|object
     *
     * @see \Doctrine\ORM\EntityRepository::__call()
     */
    public function __call($method, $arguments)
    {
        return $this->getRepository()->__call($method, $arguments);
    }

    /**
     * Retrieves the Doctrine entity repository.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected function getRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->getManager()
            ->getRepository($this->class);
    }

    /**
     * Retrieves the manager registry for an entity / classs.
     *
     * @return \Doctrine\ORM\EntityManager|\Doctrine\Common\Persistence\ObjectManager|null
     */
    protected function getManager(): \Doctrine\ORM\EntityManager
    {
        return $this->managerRegistry
            ->getManagerForClass($this->class);
    }
}