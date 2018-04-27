<?php

namespace Odan\Validation\Test;

use Odan\Validation\ErrorMessage;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 *
 * @coversDefaultClass \Odan\Validation\ErrorMessage
 */
class ValidationMessageTest extends TestCase
{
    public function testConstruct()
    {
        $message = new ErrorMessage('');
        $this->assertInstanceOf(ErrorMessage::class, $message);
    }

    public function testWithField()
    {
        $message = new ErrorMessage('required');
        $message->setField('email');

        $this->assertEquals([
            'field' => 'email',
            'message' => 'required',
        ], $message->toArray());
    }

    public function testWithFieldAndCode()
    {
        $message = new ErrorMessage('invalid');
        $message->setField('email');
        $message->setCode('5000');

        $this->assertEquals([
            'field' => 'email',
            'message' => 'invalid',
            'code' => '5000',
        ], $message->toArray());
    }
}
