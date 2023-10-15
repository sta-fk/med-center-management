<?php declare(strict_types=1);

namespace App\Employee\Repository;

use App\Employee\Entity\EmployeeContacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeContacts>
 *
 * @method EmployeeContacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeContacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeContacts[]    findAll()
 * @method EmployeeContacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeContacts::class);
    }

    public function add(EmployeeContacts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeContacts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeContacts[] Returns an array of EmployeeContacts objects
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

//    public function findOneBySomeField($value): ?EmployeeContacts
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
