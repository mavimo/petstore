<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\CollectionInterface;
use App\Model\ModelInterface;
use Doctrine\ORM\EntityManager;

final class Repository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $modelClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $modelClass
     */
    public function __construct(EntityManager $entityManager, string $modelClass)
    {
        $this->entityManager = $entityManager;
        $this->modelClass = $modelClass;
    }

    /**
     * @param CollectionInterface $collection
     */
    public function resolveCollection(CollectionInterface $collection): void
    {
        $qb = $this->entityManager->getRepository($this->modelClass)->createQueryBuilder('m');

        $countQb = clone $qb;
        $countQb->select($qb->expr()->count('m.id'));

        $collection->setCount((int) $countQb->getQuery()->getSingleScalarResult());

        $itemsQb = clone $qb;

        foreach ($collection->getSort() as $field => $order) {
            $itemsQb->addOrderBy(sprintf('m.%s', $field), $order);
        }

        $itemsQb->setFirstResult($collection->getOffset());
        $itemsQb->setMaxResults($collection->getLimit());

        $collection->setItems($itemsQb->getQuery()->getResult());
    }

    /**
     * @param string $id
     *
     * @return ModelInterface|null
     */
    public function findById(string $id): ?ModelInterface
    {
        return $this->entityManager->find($this->modelClass, $id);
    }

    /**
     * @param ModelInterface $model
     */
    public function persist(ModelInterface $model): void
    {
        $this->entityManager->persist($model);
    }

    /**
     * @param ModelInterface $model
     */
    public function remove(ModelInterface $model): void
    {
        $this->entityManager->remove($model);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
