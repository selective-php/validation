<?php

namespace Selective\Validation\Test;

use Selective\Validation\ValidationError;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\ValidationError
 */
class ValidationErrorTest extends TestCase
{
    public function testConstruct()
    {
        $message = new ValidationError('');
        $this->assertInstanceOf(ValidationError::class, $message);
    }

    public function testWithField()
    {
        $message = new ValidationError('required');
        $message->setField('email');

        $this->assertEquals([
            'field' => 'email',
            'message' => 'required',
        ], $message->toArray());
    }

    public function testWithFieldAndCode()
    {
        $message = new ValidationError('invalid');
        $message->setField('email');
        $message->setCode('5000');

        $this->assertEquals([
            'field' => 'email',
            'message' => 'invalid',
            'code' => '5000',
        ], $message->toArray());
    }
}
