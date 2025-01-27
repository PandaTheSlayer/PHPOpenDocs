<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class AllowAllCors
 */
class AllowAllCors
{
    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(Request $request, ResponseInterface $response, $next): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', 'GET,POST,DELETE,PUT,OPTIONS,HEAD,PATCH');
        $response = $response->withHeader('Access-Control-Allow-Headers', '*');

        return $response;
    }
}
