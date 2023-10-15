<?php declare(strict_types=1);

namespace App\PatientUser\Repository;

use App\PatientUser\Entity\PatientAdditionalInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PatientAdditionalInfo>
 *
 * @method PatientAdditionalInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientAdditionalInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientAdditionalInfo[]    findAll()
 * @method PatientAdditionalInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientAdditionalInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientAdditionalInfo::class);
    }

    public function add(PatientAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PatientAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PatientAdditionalInfo[] Returns an array of PatientAdditionalInfo objects
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

//    public function findOneBySomeField($value): ?PatientAdditionalInfo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
