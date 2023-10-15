<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\EmployeeSpeciality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeSpeciality>
 *
 * @method EmployeeSpeciality|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeSpeciality|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeSpeciality[]    findAll()
 * @method EmployeeSpeciality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeSpecialityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeSpeciality::class);
    }

    public function add(EmployeeSpeciality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeSpeciality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeSpeciality[] Returns an array of EmployeeSpeciality objects
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

//    public function findOneBySomeField($value): ?EmployeeSpeciality
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
