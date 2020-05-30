<?php

namespace Selective\Validation\Test;

use PHPUnit\Framework\TestCase;
use Selective\Validation\ValidationError;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\ValidationError
 */
class ValidationErrorTest extends TestCase
{
    /**
     * Test.
     */
    public function testConstruct(): void
    {
        $message = new ValidationError('');
        $this->assertInstanceOf(ValidationError::class, $message);
    }

    /**
     * Test.
     */
    public function testWithField(): void
    {
        $message = new ValidationError('required');
        $message->setField('email');

        $this->assertSame('email', $message->getField());
        $this->assertSame('required', $message->getMessage());
    }

    /**
     * Test.
     */
    public function testWithFieldAndCode(): void
    {
        $message = new ValidationError('invalid');
        $message->setField('email');
        $message->setCode('5000');

        $this->assertSame('invalid', $message->getMessage());
        $this->assertSame('email', $message->getField());
        $this->assertSame('5000', $message->getCode());
    }
}
