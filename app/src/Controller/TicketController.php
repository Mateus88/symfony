<?php
// src/Controller/TicketController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\BusTicketService;
use App\Service\CityService;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketController extends BaseController
{
    private $busTicketService;
    private $cityService;

    public function __construct(BusTicketService $busTicketService, CityService $cityService)
    {
        $this->busTicketService = $busTicketService;
        $this->cityService      = $cityService;
    }

    #[Route('/ticket', name: 'ticket_search')]
    public function ticketSearch(): Response
    {
        $cities = $this->cityService->getAllCities();

        return $this->render(
            'ticket/ticketsearch.html.twig',
            [
                'cities' => $cities,
                'title'  => 'Ticket Search',
            ]
        );
    }

    #[Route('/ticket/scheduledtimes', name: 'ticket_info_hours')]
    public function ticketInfoHours(Request $request): Response
    {
        $sourceCity      = (int) $request->get('sourceCity');
        $destinationCity = (int) $request->get('destinationCity');
        $date            = $request->get('date');

        return $this->render(
            'ticket/ticketscheduleddetails.html.twig',
            [
                'title'           => 'Trip Scheduled Times',
                'sourceCity'      => $sourceCity,
                'destinationCity' => $destinationCity,
                'date'            => $date
            ]
        );
    }

    #[Route('/api/ticket/search', name: 'ticket_search_api')]
    public function ticketSearchByParameters(Request $request): JsonResponse
    {
        try {
            $this->validateAuthorizationApi($request->headers->get('apikey'));
            $sourceCity = (int) $request->get('sourceCity');
            $date       = $request->get('date');
            $response   = $this->busTicketService->getTicketsBySourceCityAndDate($sourceCity, $date);
            $statusCode = 200;
        } catch (\Exception $e) {
            $errorDetail = $this->handleException($e);
            $statusCode  = $errorDetail['code'];
            $response    = $errorDetail['message'];
        }

        return new JsonResponse(["response" => $response], $statusCode);
    }

    #[Route('/api/ticket/{sourceCity}/to/{destinationCity}', name: 'ticket_search_api_details')]
    public function tickeTravelMoreDetails(Request $request, $sourceCity, $destinationCity): JsonResponse
    {
        try {
            $this->validateAuthorizationApi($request->headers->get('apikey'));
            $date     = $request->get('date');
            $response = $this->busTicketService->getTicketsBySourceAndDestinationCityByDate(
                $sourceCity,
                $destinationCity,
                $date
            );
            $statusCode = 200;
        } catch (\Exception $e) {
            $errorDetail = $this->handleException($e);
            $statusCode  = $errorDetail['code'];
            $response    = $errorDetail['message'];
        }
        return new JsonResponse(["response" => $response], $statusCode);
    }
}
