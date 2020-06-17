<?php

namespace Selective\Validation\Test\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Slim\Psr7\Factory\ResponseFactory;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\Middleware\ValidationExceptionMiddleware
 */
class ValidationExceptionMiddlewareTest extends TestCase
{
    use MiddlewareTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testNoError(): void
    {
        $middleware = new ValidationExceptionMiddleware(
            new ResponseFactory(),
            new ErrorDetailsResultTransformer(),
            new JsonEncoder()
        );

        $response = $this->runQueue([
            $middleware,
        ]);

        static::assertSame('', (string)$response->getBody());
        static::assertSame(200, $response->getStatusCode());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testWithError(): void
    {
        $middleware = new ValidationExceptionMiddleware(
            new ResponseFactory(),
            new ErrorDetailsResultTransformer(),
            new JsonEncoder()
        );

        $response = $this->runQueue([
            $middleware,
            new ErrorMiddleware(),
        ]);

        static::assertSame(
            '{"error":{"message":"Please check your input","code":422,"details":' .
            '[{"message":"Input required","field":"username"}]}}',
            (string)$response->getBody()
        );

        static::assertSame(
            StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        );

        static::assertSame(
            'application/json',
            $response->getHeaderLine('content-type')
        );
    }
}
