<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\EmployeeInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeInfo>
 *
 * @method EmployeeInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeInfo[]    findAll()
 * @method EmployeeInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeInfo::class);
    }

    public function add(EmployeeInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getEmployeeInfoForAppointment(int $employeeId): array
    {
        return $this->createQueryBuilder('ei')
            ->select('ei.firstName', 'ei.lastName', 'ei.slug as employeeSlug', 'd.slug as departmentSlug')
            ->innerJoin('ei.employee', 'e')
            ->innerJoin('e.department', 'd')
            ->where('e.id = :emplId')
            ->setParameter('emplId', $employeeId)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return EmployeeInfo[] Returns an array of EmployeeInfo objects
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

//    public function findOneBySomeField($value): ?EmployeeInfo
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
