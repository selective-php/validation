<?php

namespace Odan\Validation\Test;

use Odan\Validation\ServiceResult;

/**
 * Tests.
 *
 * @coversDefaultClass \Odan\Validation\ServiceResultTest
 */
class ServiceResultTest extends ValidationResultTest
{
    /**
     * Test instance.
     */
    public function testInstance()
    {
        $actual = new ServiceResult();
        $this->assertInstanceOf(ServiceResult::class, $actual);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCode()
    {
        $val = new ServiceResult();
        $actual = $val->getCode();
        $this->assertSame(null, $actual);

        $val->setCode('500');
        $actual = $val->getCode();
        $this->assertSame('500', $actual);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testResult()
    {
        $val = new ServiceResult();
        $actual = $val->getData();
        $this->assertSame(null, $actual);

        $val->setData(['first_name' => 'max']);
        $resultText = $val->getData();
        $this->assertSame(['first_name' => 'max'], $resultText);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testArray()
    {
        $val = new ServiceResult();
        $actual = $val->toArray();
        $this->assertSame(['success' => true], $actual);

        $val->setCode('500');
        $actual = $val->toArray();
        $this->assertSame(['success' => true, 'code' => '500'], $actual);

        $val->setData(['id' => 1]);
        $actual = $val->toArray();
        $this->assertSame(['success' => true, 'code' => '500', 'data' => ['id' => 1]], $actual);
    }
}
