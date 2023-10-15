<?php declare(strict_types=1);

namespace App\Appointments\Repository;

use App\Appointments\Entity\Appointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointments>
 *
 * @method Appointments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointments[]    findAll()
 * @method Appointments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointments::class);
    }

    public function add(Appointments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appointments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAppointmentsOnDayForEmployee(int $employeeId, \DateTimeImmutable $time)
    {
        return $this->createQueryBuilder('a')
            ->select('a.time', 's.id as serviceId', 's.duration as duration')
            ->join('a.employee', 'e')
            ->join('a.service', 's')
            ->where('e.id = :emplId')
            ->andWhere('DATE_FORMAT(a.time, \'%Y-%m-%d\') = :date')
            ->setParameter('emplId', $employeeId)
            ->setParameter('date', $time->format('Y-m-d'))
            ->orderBy('a.time', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getAppointmentsOnDayForPatient(int $patientProfileId, \DateTimeImmutable $time)
    {
        return $this->createQueryBuilder('a')
            ->select('a.time', 's.id as serviceId', 's.duration as duration')
            ->join('a.patient', 'p')
            ->join('a.service', 's')
            ->where('p.id = :patientId')
            ->andWhere('DATE_FORMAT(a.time, \'%Y-%m-%d\') = :date')
            ->setParameter('patientId', $patientProfileId)
            ->setParameter('date', $time->format('Y-m-d'))
            ->orderBy('a.time', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Appointments[] Returns an array of Appointments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Appointments
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
