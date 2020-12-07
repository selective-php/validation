<?php

namespace Selective\Validation\Test\Exception;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\Test\TestService;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\Exception\ValidationException
 */
class ValidationExceptionTest extends TestCase
{
    /**
     * Test pseudo action.
     */
    public function testSuccessAction(): void
    {
        $service = new TestService();
        $result = $service->process(1);

        $this->assertSame('{"success":true}', (json_encode($result)));
    }

    /**
     * Test pseudo action.
     */
    public function testValidationFailedAction(): void
    {
        $this->expectException(ValidationException::class);
        $service = new TestService();
        $service->process(0);
    }
}
