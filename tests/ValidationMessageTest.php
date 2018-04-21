<?php

namespace Odan\Validation\Test;

use Odan\Validation\ValidationMessage;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 *
 * @coversDefaultClass \Odan\Validation\ValidationMessage
 */
class ValidationMessageTest extends TestCase
{
    public function testConstruct()
    {
        $message = new ValidationMessage('', '');
        $this->assertInstanceOf(ValidationMessage::class, $message);
    }

    public function testWithField()
    {
        $message = new ValidationMessage('email', 'required');
        $this->assertEquals([
            'field' => 'email',
            'message' => 'required',
        ], $message->toArray());
    }

    public function testWithFieldAndCode()
    {
        $message = new ValidationMessage('email', 'invalid', '5000');
        $this->assertEquals([
            'field' => 'email',
            'message' => 'invalid',
            'code' => '5000',
        ], $message->toArray());
    }
}
