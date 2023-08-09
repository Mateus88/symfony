<?php
// src/Controller/BaseController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Exception\RequestException;


class BaseController extends AbstractController
{
    /**
     * Validate Authorization API
     *
     * @param string|null $apiKey
     *
     * @return void
     * @throws Exception
     */
    protected function validateAuthorizationApi(?string $apiKey): void
    {
        if ($apiKey != $this->getParameter('app.apikey')) {
            throw new RequestException('Unauthorized api key provided', 401);
        }
    }

    /**
     * Handle exception
     *
     * @param object $exception
     *
     * @return array
     */
    protected function handleException(object $exception): array
    {
        return [
            'code'   => $exception->getCode() ?? 500,
            'message'=> $exception->getMessage() ?? 'Error to process request'
        ];
    }
}
