<?php

namespace Odan\Validation\Test;

use Odan\Validation\ValidationMessage;
use PHPUnit\Framework\TestCase;

/**
 * ValidationResult tests.
 *
 * @coversDefaultClass \Odan\Validation\ValidationMessage
 */
class ValidationMessageTest extends TestCase
{
    /**
     * Test instance.
     */
    public function testInstance()
    {
        $actual = new ValidationMessage();
        $this->assertInstanceOf(ValidationMessage::class, $actual);
    }

    /**
     * Tests getMessage and setMessage functions.
     *
     * @return void
     */
    public function testSetSuccessMessage()
    {
        $val = new ValidationMessage();
        $val->setMessage('test');
        $resultText = $val->getMessage();
        $this->assertSame('test', $resultText);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with two strings.
     *
     * @return void
     */
    public function testErrors()
    {
        $val = new ValidationMessage();
        $val->addError('error1', 'failed');
        $result = $val->failed();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with an empty string for the first parameter.
     *
     * @return void
     */
    public function testErrorsEmptyFieldOne()
    {
        $val = new ValidationMessage();
        $val->addError('', 'failed');
        $result = $val->failed();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with an empty string for the second parameter.
     *
     * @return void
     */
    public function testErrorsEmptyFieldTwo()
    {
        $val = new ValidationMessage();
        $val->addError('error1', '');
        $result = $val->failed();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with two empty strings.
     *
     * @return void
     */
    public function testErrorsEmptyBoth()
    {
        $val = new ValidationMessage();
        $val->addError('', '');
        $result = $val->failed();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with null for the second parameter.
     *
     * @return void
     */
    public function testErrorsWithMessage()
    {
        $val = new ValidationMessage();
        $val->addError('email', 'required');
        $result = $val->failed();
        $this->assertTrue($result);
        $this->assertEquals(['field' => 'email', 'message' => 'required'], $val->getFirstError());
    }

    /**
     * Tests success function.
     * Tests for no errors.
     *
     * @return void
     */
    public function testNoErrors()
    {
        $val = new ValidationMessage();
        $result = $val->failed();
        $this->assertFalse($result);
    }

    /**
     * Tests __construct function.
     *
     * @return void
     */
    public function testGetMessage()
    {
        $val = new ValidationMessage();
        $val->setMessage('Check your input');
        $this->assertSame('Check your input', $val->getMessage());

        $val->addError('field', 'error message');
        $this->assertSame('Check your input', $val->getMessage());
    }

    /**
     * Tests clear function.
     *
     * @return void
     */
    public function testClear()
    {
        $val = new ValidationMessage();
        $val->setMessage('Errors');
        $val->addError('error', 'error');
        $val->clear();
        $result = $val->failed();
        $this->assertFalse($result);
    }

    /**
     * Tests getErrors function.
     *
     * @return void
     */
    public function testGetErrors()
    {
        $val = new ValidationMessage();
        $errorFieldName = 'ERROR';
        $errorMessage = 'This is an error!';
        $val->addError($errorFieldName, $errorMessage);
        $result = $val->getErrors();
        $this->assertSame($result[0]['field'], $errorFieldName);
        $this->assertSame($result[0]['message'], $errorMessage);
    }

    /**
     * Tests toArray function.
     *
     * @return void
     */
    public function testToArray()
    {
        $val = new ValidationMessage();
        $val->setMessage('Errors');
        $val->addError('error1', 'error');
        $val->addError('error2', 'error', '5000');
        $result = $val->toArray();
        $this->assertSame($result['message'], 'Errors');
        $this->assertSame($result['errors'][0]['field'], 'error1');
        $this->assertSame($result['errors'][0]['message'], 'error');
        $this->assertSame($result['errors'][1]['field'], 'error2');
        $this->assertSame($result['errors'][1]['message'], 'error');
        $this->assertSame($result['errors'][1]['code'], '5000');
    }
}
