<?php declare(strict_types=1);

namespace App\Department\Repository;

use App\Department\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Department>
 *
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function add(Department $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Department $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getActiveDepartments()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.services', 's')
            ->innerJoin('d.employees', 'e')
            ->where('d.isActive = true')
            ->andWhere('s.id IS NOT NULL')
            ->andWhere('e.id IS NOT NULL')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getActiveDepartmentsWithServices()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.services', 's')
            ->where('d.isActive = true')
            ->andWhere('s.id IS NOT NULL')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getActiveDepartmentsExcludeWithoutDetails()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.services', 's')
            ->innerJoin('d.employees', 'e')
            ->where('d.isActive = true')
            ->andWhere('s.id IS NOT NULL')
            ->andWhere('s.details IS NOT NULL')
            ->andWhere('e.id IS NOT NULL')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getActiveDepartmentsWithEmployees()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.employees', 'e')
            ->where('d.isActive = true')
            ->andWhere('e.id IS NOT NULL')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Department[] Returns an array of Department objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Department
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
