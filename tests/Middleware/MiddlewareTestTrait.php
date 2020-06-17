<?php

namespace Selective\Validation\Test\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * Test.
 */
trait MiddlewareTestTrait
{
    /**
     * Run middleware stack.
     *
     * @param array<mixed> $queue The queue
     *
     * @return ResponseInterface The response
     */
    protected function runQueue(array $queue): ResponseInterface
    {
        $queue[] = new ResponseFactoryMiddleware();

        $request = $this->createRequest();
        $relay = new Relay($queue);

        return $relay->handle($request);
    }

    /**
     * Factory.
     */
    protected function createRequest(): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest('GET', '/');
    }
}
