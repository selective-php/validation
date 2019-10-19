<?php

namespace Selective\Validation\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Selective\Validation\Encoder\EncoderInterface;
use Selective\Validation\ValidationException;

/**
 * A JSON validation exception middleware.
 */
final class ValidationExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * Constructor.
     *
     * @param ResponseFactoryInterface $responseFactory The response factory
     * @param EncoderInterface $encoder The encoder
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        EncoderInterface $encoder
    ) {
        $this->responseFactory = $responseFactory;
        $this->encoder = $encoder;
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            $response = $this->responseFactory->createResponse()->withStatus(422);

            $response->getBody()->write($this->encoder->encode([
                'error' => $exception->getValidation()->toArray(),
            ]));

            return $response;
        }
    }
}
