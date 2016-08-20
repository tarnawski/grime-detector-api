<?php
namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GrimeDetectorController extends BaseController
{
    /**
     * @return Response
     */
    public function pingAction()
    {
        return JsonResponse::create(['pong'], Response::HTTP_OK);
    }
}
