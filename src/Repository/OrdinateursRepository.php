<?php

namespace App\Repository;

use App\Entity\Ordinateurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordinateurs>
 *
 * @method Ordinateurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordinateurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordinateurs[]    findAll()
 * @method Ordinateurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdinateursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordinateurs::class);
    }

    public function add(Ordinateurs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ordinateurs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*
     * reuturn the latest computer added on website
     * @return Ordinateurs[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('l')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Ordinateurs[] Returns an array of Ordinateurs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ordinateurs
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}