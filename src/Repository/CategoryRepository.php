<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * CategoryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param string|null $name
     * @return Category|null
     */
    public function findOneByName(?string $name): ?Category
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getAllCategory(int $page, int $limit): array
    {
        $qb = $this
            ->createQueryBuilder('category')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
        $model = $qb->getQuery()->execute();
        $qbCount = $this
            ->createQueryBuilder('category')
            ->select('count(category.id)');
        $count = $qbCount->getQuery()->execute();
        $data = [
            'data' => $model,
            'count' => $count,
        ];

        return $data;
    }

    /**
     * @param Category $category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category): void
    {
        $em = $this->getEntityManager();
        $em->persist($category);
        $em->flush();
    }
}
