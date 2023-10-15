<?php declare(strict_types=1);

namespace App\PatientUser\Repository;

use App\PatientUser\Entity\PatientProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PatientProfile>
 *
 * @method PatientProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientProfile[]    findAll()
 * @method PatientProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientProfile::class);
    }

    public function add(PatientProfile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PatientProfile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPatientAppointments(int $patientId): array
    {
        return $this->createQueryBuilder('p')
            ->select('ap.id', 'p.id as patientId', 'e.id as employeeId','ap.time', 's.name as serviceName', 's.price as servicePrice', 's.duration as serviceDuration')
            ->innerJoin('p.appointments', 'ap')
            ->innerJoin('ap.employee', 'e')
            ->innerJoin('ap.service', 's')
            ->where('p.id = :patientId')
            ->andWhere('DATE_FORMAT(ap.time, \'%Y-%m-%dT%H:%i:%s\') > :date')
            ->orderBy('ap.time', 'ASC')
            ->setParameter('date', (new \DateTimeImmutable('now'))->format('Y-m-d\TH:i:s'))
            ->setParameter('patientId', $patientId)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return PatientProfile[]
     */
    public function getTomorrowAppointmentsForAllPatients(): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.appointments', 'ap')
            ->innerJoin('ap.employee', 'e')
            ->innerJoin('ap.service', 's')
            ->where('DATE_FORMAT(ap.time, \'%Y-%m-%d\') = :date')
            ->orderBy('ap.time', 'ASC')
            ->setParameter('date',  (new \DateTimeImmutable('now'))->modify("+1 day")->format('Y-m-d'))
            ->getQuery()
            ->getResult()
            ;
    }

    public function getPatientUpcomingAppointmentsCount(int $patientId): int
    {
        return (int)$this->createQueryBuilder('p')
            ->select('COUNT(ap.id)')
            ->innerJoin('p.appointments', 'ap')
            ->where('p.id = :patientId')
            ->andWhere('DATE_FORMAT(ap.time, \'%Y-%m-%dT%H:%i:%s\') > :date')
            ->orderBy('ap.time', 'ASC')
            ->setParameter('date', (new \DateTimeImmutable('now'))->format('Y-m-d\TH:i:s'))
            ->setParameter('patientId', $patientId)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getPatientPastAppointmentsCount(int $patientId): int
    {
        return (int)$this->createQueryBuilder('p')
            ->select('COUNT(ap.id)')
            ->innerJoin('p.appointments', 'ap')
            ->where('p.id = :patientId')
            ->andWhere('DATE_FORMAT(ap.time, \'%Y-%m-%dT%H:%i:%s\') < :date')
            ->orderBy('ap.time', 'ASC')
            ->setParameter('date', (new \DateTimeImmutable('now'))->format('Y-m-d\TH:i:s'))
            ->setParameter('patientId', $patientId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

//    /**
//     * @return PatientProfile[] Returns an array of PatientProfile objects
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

//    public function findOneBySomeField($value): ?PatientProfile
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
