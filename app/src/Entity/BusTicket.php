<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BusTicketRepository")
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="bus_ticket")
 */
class BusTicket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="sourceCity")
     */
    public $sourceCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="destinationCity")
     */
    public $destinationCity;

    /**
     * @ORM\Column(type="datetime", name="departureTime")
     */
    public $departureTime;

    /**
     * @ORM\Column(type="datetime", name="arrivalTime")
     */
    public $arrivalTime;

    /**
     * @ORM\Column(type="decimal", name="price")
     */
    public $price;

    /**
     * @ORM\Column(type="integer", name="status")
     */
    public $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceCity(): ?string
    {
        return $this->sourceCity;
    }

    public function setSourceCity(?string $sourceCity): self
    {
        $this->sourceCity = $sourceCity;

        return $this;
    }

    public function getDestinationCity(): ?string
    {
        return $this->destinationCity;
    }

    public function setDestinationCity(?string $destinationCity): self
    {
        $this->destinationCity = $destinationCity;

        return $this;
    }

    public function getDepartureTime(): ?string
    {
        return $this->departureTime;
    }

    public function setDepartureTime(?string $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getArrivalTime(): ?string
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(?string $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

}