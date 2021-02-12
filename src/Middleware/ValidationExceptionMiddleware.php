<?php

namespace Selective\Validation\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Selective\Validation\Encoder\EncoderInterface;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\Transformer\ResultTransformerInterface;

/**
 * A JSON validation exception middleware.
 */
final class ValidationExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResultTransformerInterface
     */
    private $transformer;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Constructor.
     *
     * @param ResponseFactoryInterface $responseFactory The response factory
     * @param ResultTransformerInterface $transformer The data transformer
     * @param EncoderInterface $encoder The encoder
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        ResultTransformerInterface $transformer,
        EncoderInterface $encoder
    ) {
        $this->transformer = $transformer;
        $this->encoder = $encoder;
        $this->responseFactory = $responseFactory;
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
            $response = $this->responseFactory->createResponse()
                ->withStatus((int)$exception->getCode())
                ->withHeader('Content-Type', $this->encoder->getContentType());

            $validationResult = $exception->getValidationResult();
            if ($validationResult) {
                $data = $this->transformer->transform($validationResult, $exception);
                $content = $this->encoder->encode($data);
                $response->getBody()->write($content);
            }

            return $response;
        }
    }
}
