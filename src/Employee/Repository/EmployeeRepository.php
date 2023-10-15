<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function add(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Employee[]
     */
    public function getActiveEmployeesByDepartmentId(int $departmentId): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.department', 'd')
            ->where('e.department = :val')
            ->andWhere('d.isActive = true')
            ->andWhere('e.isActive = true')
            ->setParameter('val', $departmentId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchEmployeesByName(string $employeeName, ?int $departmentId): array
    {
        $qb = $this->createQueryBuilder('e');

        if ($departmentId > 0) {
            $qb
                ->where('e.department = :dId')
                ->andWhere('d.isActive = true')
                ->setParameter('dId', $departmentId)
            ;
        }

        return $qb
            ->select('ei.firstName', 'ei.lastName', 'e.brief', 'e.id as employeeId', 'd.id as departmentId', 'd.name as departmentName', 'ei.slug as employeeSlug', 'd.slug as departmentSlug')
            ->innerJoin('e.employeeInfo', 'ei')
            ->innerJoin('e.department', 'd')
            ->andWhere('e.isActive = true')
            ->andWhere('ei.firstName LIKE :name')
            ->orWhere('ei.lastName LIKE :name')
            ->orderBy('ei.firstName', 'ASC')
            ->setParameter('name', '%'.$employeeName.'%')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
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

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
