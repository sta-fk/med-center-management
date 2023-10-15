<?php declare(strict_types=1);

namespace App\Patient\Repository;

use App\Patient\Entity\PatientEhealthInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PatientEhealthInfo>
 *
 * @method PatientEhealthInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientEhealthInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientEhealthInfo[]    findAll()
 * @method PatientEhealthInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientEhealthInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientEhealthInfo::class);
    }

    public function add(PatientEhealthInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PatientEhealthInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PatientEhealth[] Returns an array of PatientEhealth objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PatientEhealthInfo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
