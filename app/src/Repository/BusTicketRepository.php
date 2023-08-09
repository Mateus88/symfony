<?php

namespace App\Repository;

use App\Entity\BusTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method BusTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusTicket[]    findAll()
 * @method BusTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusTicket::class);
    }

    /**
     * Get Ticket by same city to specified date
     *
     * @param int     $sourceCity
     * @param string  $startDate
     * @param string  $endDate
     * @param string  $currentDate
     * @param int     $isActive
     * @return array
     */
    public function getTicketsBySourceCityAndDate(
        int $sourceCity,
        string $startDate,
        string $endDate,
        string $currentDate,
        int $isActive
    ): array {

        return $this->createQueryBuilder('bt')
            ->select(
                'c.name as sourceCity',
                'c2.name as destinationCity',
                'bt.departureTime',
                'bt.sourceCity as sourceCityId',
                'bt.destinationCity as destinationCityId'
            )
            ->innerJoin('App\Entity\City', 'c', 'WITH', 'bt.sourceCity = c.id')
            ->innerJoin('App\Entity\City', 'c2', 'WITH', 'bt.destinationCity = c2.id')
            ->where('bt.sourceCity = :sourceCity')
            ->andWhere('bt.departureTime BETWEEN :startDate AND :endDate')
            ->andWhere('bt.departureTime >= :currentDate')
            ->andWhere('bt.status = :isActive')
            ->orderBy('bt.id', 'DESC')
            ->groupBy('bt.sourceCity')
            ->addGroupBy('bt.destinationCity')
            ->setParameter('sourceCity', $sourceCity)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('currentDate', $currentDate)
            ->setParameter('isActive', $isActive)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get ticket schedules from a certain city to another city depending on the date
     *
     * @param int     $sourceCity
     * @param string  $startDate
     * @param string  $endDate
     * @param string  $currentDate
     * @param int     $isActive
     * @param int     $destinationCity
     * @return array
     */
    public function getTicketsBySourceAndDestinationCityByDate(
        int $sourceCity,
        string $startDate,
        string $endDate,
        string $currentDate,
        int $isActive,
        int $destinationCity
    ): array {

        return $this->createQueryBuilder('bt')
            ->select(
                'c.name as sourceCity',
                'c2.name as destinationCity',
                'bt.departureTime',
                'bt.arrivalTime',
                'bt.price '
            )
            ->innerJoin('App\Entity\City', 'c', 'WITH', 'bt.sourceCity = c.id')
            ->innerJoin('App\Entity\City', 'c2', 'WITH', 'bt.destinationCity = c2.id')
            ->where('bt.sourceCity = :sourceCity')
            ->andWhere('bt.destinationCity = :destinationCity')
            ->andWhere('bt.departureTime BETWEEN :startDate AND :endDate')
            ->andWhere('bt.departureTime >= :currentDate')
            ->andWhere('bt.status = :isActive')
            ->orderBy('bt.id', 'DESC')
            ->setParameter('sourceCity', $sourceCity)
            ->setParameter('destinationCity', $destinationCity)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('currentDate', $currentDate)
            ->setParameter('isActive', $isActive)
            ->getQuery()
            ->getResult();
    }
}
