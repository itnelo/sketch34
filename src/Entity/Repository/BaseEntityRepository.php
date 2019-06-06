<?php

declare(strict_types=1);

namespace App\Entity\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
//use Exception\EntityNotFoundException;

/**
 * Provides additional contract-based methods for standard ORM repository API.
 *
 * - Custom methods should use {getQueryBuilder} as starting point for query building.
 * - Custom methods should build Criteria object and pass it to {getQuery} before result evaluation.
 */
class BaseEntityRepository extends EntityRepository
{
    /**
     * Returns an entity by its identifier or throws exception
     *
     * @param mixed    $id          The identifier.
     * @param int|null $lockMode    One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              during the search.
     * @param int|null $lockVersion The lock version.
     *
     * @return object The entity instance.
     *
     * @throws EntityNotFoundException
     */
    public function require($id, $lockMode = null, $lockVersion = null)
    {
        $entity = $this->find($id, $lockMode, $lockVersion);

        $classMetadata = $this->getClassMetadata();

        if (!$entity instanceof $classMetadata->name) {
            // dont want it now.
            //throw EntityNotFoundException::withClassAndId($classMetadata->name, $id);
        }

        return $entity;
    }

    /**
     * Calls related EntityManager to persist an entity and, optionally, flush
     *
     * @param object $entity  The instance to make managed and persistent.
     * @param bool   $isFlush Whenever EntityManager should perform flush
     *
     * @return void
     *
     * @throws OptimisticLockException If a version check on an entity that
     *         makes use of optimistic locking fails on flush.
     * @throws ORMException
     *
     * @see EntityManagerInterface::persist()
     * @see EntityManagerInterface::flush()
     * @see https://stackoverflow.com/a/20517528/3121455 (merge logic can be implemented if needed)
     */
    public function save($entity, bool $isFlush = true): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);

        if ($isFlush) {
            $entityManager->flush();
        }
    }
}
