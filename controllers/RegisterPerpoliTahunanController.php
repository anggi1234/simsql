<?php

namespace PHPMaker2021\simrs;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * register_perpoli_tahunan controller
 */
class RegisterPerpoliTahunanController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RegisterPerpoliTahunanSummary");
    }
}
