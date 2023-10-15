<?php declare(strict_types=1);

namespace App\Catalog\Repository;

use App\Catalog\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function add(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Service[] Returns an array of ServiceModel objects
     */
    public function getServicesByDepartmentId($department): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.department = :department')
            ->andWhere('s.active = true')
            ->andWhere('s.isResearch = false')
            ->orderBy('s.id', 'ASC')
            ->setParameter('department', $department)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Service[] Returns an array of ServiceModel objects
     */
    public function getResearches(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.code IS NULL')
            ->andWhere('s.price IS NULL')
            ->andWhere('s.department IS NULL')
            ->andWhere('s.parentService IS NULL')
            ->andWhere('s.active = true')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Sort by details (first with details)
     */
    public function searchServicesByName(string $serviceName, ?int $departmentId): array
    {
        $qb = $this->createQueryBuilder('s');

        if ($departmentId > 0) {
            $qb
                ->innerJoin('s.department', 'd')
                ->where('s.department = :dId')
                ->andWhere('d.isActive = true')
                ->setParameter('dId', $departmentId)
                ;
        }

        return $qb
            ->select('s.name', 's.price',  's.details')
            ->andWhere('s.name LIKE :name')
            ->andWhere('s.price IS NOT NULL')
            ->andWhere('s.active = true')
            ->orderBy('s.details', 'DESC')
            ->addOrderBy('s.name', 'ASC')
            ->setParameter('name', '%'.$serviceName.'%')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return ServiceModel[] Returns an array of ServiceModel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ServiceModel
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
