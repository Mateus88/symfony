<?php

namespace App\Service;

use App\Repository\CityRepository;


class CityService
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Finds all countries
     * @return array
     */
    public function getAllCities(): array
    {
        return $this->cityRepository->findAll();
    }
}
