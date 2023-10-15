<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\EmployeeQualification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeQualification>
 *
 * @method EmployeeQualification|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeQualification|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeQualification[]    findAll()
 * @method EmployeeQualification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeQualificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeQualification::class);
    }

    public function add(EmployeeQualification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeQualification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeQualification[] Returns an array of EmployeeQualification objects
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

//    public function findOneBySomeField($value): ?EmployeeQualification
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
