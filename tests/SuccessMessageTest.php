<?php

namespace Odan\Validation\Test;

use Odan\Validation\SuccessMessage;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 *
 * @coversDefaultClass \Odan\Validation\SuccessMessage
 */
class SuccessMessageTest extends TestCase
{
    public function testConstruct()
    {
        $actual = new SuccessMessage(true, 'Ok');
        $this->assertInstanceOf(SuccessMessage::class, $actual);
    }

    public function testFailed()
    {
        $this->markTestSkipped();
    }

    public function testSet()
    {
        $this->markTestSkipped();
    }

    public function testMessage()
    {
        $this->markTestSkipped();
    }


    public function testSuccess()
    {
        $this->markTestSkipped();
    }

    public function testToArray()
    {
        $this->markTestSkipped();
    }
}
