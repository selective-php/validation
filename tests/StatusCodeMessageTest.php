<?php

namespace Odan\Validation\Test;

use Odan\Validation\StatusCodeMessage;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 *
 * @coversDefaultClass \Odan\Validation\StatusCodeMessage
 */
class StatusCodeMessageTest extends TestCase
{
    public function testConstruct()
    {
        $actual = new StatusCodeMessage(0, 'message');
        $this->assertInstanceOf(StatusCodeMessage::class, $actual);
    }
    
    public function testToArray()
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

    public function testStatus()
    {
        $this->markTestSkipped();
    }


}
