<?php

namespace Selective\Validation\Test;

use Selective\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\ValidationExceptionTest
 */
class ValidationExceptionTest extends TestCase
{
    /**
     * Test pseudo action.
     */
    public function testSuccessAction()
    {
        $service = new TestService();
        $result = $service->process(1);
        $json = $this->withJson($result);

        $this->assertSame('{"success":true,"message":"Successfully","code":0,"data":{"foo":"value"}}', $json);
    }

    /**
     * Test pseudo action.
     */
    public function testValidationFailedAction()
    {
        try {
            $service = new TestService();
            $result = $service->process(0);
            $json = $this->withJson($result);
        } catch (ValidationException $exception) {
            $validation = $exception->getValidation();
            $json = $this->withStatus(422)->withJson($validation);
        }

        $this->assertSame('{"message":"Please check your input","errors":[{"message":"invalid","field":"id"}]}', $json);
    }

    /**
     * Pseudo response method.
     *
     * @param mixed $data Data
     *
     * @return string Json
     */
    protected function withJson($data): string
    {
        $result = json_encode($data);

        if ($result === false) {
            throw new RuntimeException('Json encoding failed');
        }

        return $result;
    }

    /**
     * Pseudo response method.
     *
     * @param mixed $code Code
     *
     * @return $this self
     */
    protected function withStatus($code)
    {
        // pseudo usage for phpstan only
        trim($code);

        return $this;
    }
}
