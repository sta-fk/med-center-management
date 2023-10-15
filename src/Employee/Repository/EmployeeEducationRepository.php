<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\EmployeeEducation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeEducation>
 *
 * @method EmployeeEducation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeEducation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeEducation[]    findAll()
 * @method EmployeeEducation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeEducationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeEducation::class);
    }

    public function add(EmployeeEducation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeEducation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeEducation[] Returns an array of EmployeeEducation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmployeeEducation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
