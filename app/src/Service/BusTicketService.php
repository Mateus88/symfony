<?php

namespace App\Service;

use App\Repository\BusTicketRepository;
use App\Exception\InvalidArgumentException;


class BusTicketService
{
    private $busTicketRepository;

    public function __construct(BusTicketRepository $busTicketRepository)
    {
        $this->busTicketRepository = $busTicketRepository;
    }

    /**
     * Get Tickets by source city and respective date
     * @param int    $sourceCity
     * @param string $date
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function getTicketsBySourceCityAndDate(int $sourceCity, string $date): array
    {
        $this->validateParameters($sourceCity, $date);
        $parameters = $this->setParameters($sourceCity, $date, null);
        return $this->busTicketRepository->getTicketsBySourceCityAndDate(
            $parameters['sourceCity'],
            $parameters['startDate'],
            $parameters['endDate'],
            $parameters['currentDate'],
            $parameters['isActive']
        );
    }

    /**
     * Get Tickets by source city and respective date
     * @param int    $sourceCity
     * @param int    $destinationCity
     * @param string $date
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function getTicketsBySourceAndDestinationCityByDate(
        int $sourceCity,
        int $destinationCity,
        string $date
    ): array {
        $this->validateParameters($sourceCity, $date);
        $parameters = $this->setParameters($sourceCity, $date, $destinationCity);
        return $this->busTicketRepository->getTicketsBySourceAndDestinationCityByDate(
            $parameters['sourceCity'],
            $parameters['startDate'],
            $parameters['endDate'],
            $parameters['currentDate'],
            $parameters['isActive'],
            $parameters['destinationCity'],
        );
    }

    /**
     * Validate parameters to search for tickets
     *
     * @param int    $sourceCity
     * @param string $date
     * @return void
     */
    private function validateParameters(int $sourceCity, string $date)
    {

        if (empty($sourceCity) || empty($date)) {
            throw new InvalidArgumentException('Parameters invalid', 400);
        }

        if (!is_int($sourceCity)) {
            throw new InvalidArgumentException('City needs to be an integer', 400);
        }

        if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $date)) {
            throw new InvalidArgumentException('Date invalid format (yyyy-mm-dd)', 400);
        }
    }

    /**
     * Validate parameters to search for tickets
     *
     * @param int      $sourceCity
     * @param string   $date
     * @param int|null $destinationCity
     * @param int      $isActive
     * @return array
     */
    private function setParameters(
        int $sourceCity,
        string $date,
        ?int $destinationCity = null,
        int $isActive = 1
    ): array {
        $parameters                     = [];
        $parameters['sourceCity']       = $sourceCity;
        $parameters['destinationCity']  = $destinationCity;
        $parameters['startDate']        = $date . " 00:00:00";
        $parameters['endDate']          = $date . " 23:59:59";
        $parameters['currentDate']      = date("Y-m-d H:i:s");
        $parameters['isActive']         = (int) $isActive;

        return $parameters;
    }
}
