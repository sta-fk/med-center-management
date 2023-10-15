<?php

namespace App\PatientUser\Repository;

use App\PatientUser\Entity\PatientServiceResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PatientServiceResult>
 *
 * @method PatientServiceResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientServiceResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientServiceResult[]    findAll()
 * @method PatientServiceResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientServiceResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientServiceResult::class);
    }

    public function add(PatientServiceResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PatientServiceResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getServiceResultByDate(int $profileId, string $serviceSlug, string $date): ?PatientServiceResult
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.service', 's')
            ->where('p.patient = :profileId')
            ->andWhere('s.slug = :serviceSlug')
            ->andWhere('DATE_FORMAT(p.date, \'%d-%m-%Y\') = :date')
            ->setParameter('profileId', $profileId)
            ->setParameter('serviceSlug', $serviceSlug)
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getResultsGroupedByDate(int $profileId)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.patient = :profileId')
            ->andWhere('p.date BETWEEN :halfYearAgo AND :now')
            ->orderBy('p.date', 'DESC')
            ->setParameter('profileId', $profileId)
            ->setParameter('halfYearAgo', (new \DateTimeImmutable('now'))->modify("-6 months")->format('Y-m-d'))
            ->setParameter('now', (new \DateTimeImmutable('now'))->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return PatientServiceResult[] Returns an array of PatientServiceResult objects
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

//    public function findOneBySomeField($value): ?PatientServiceResult
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
