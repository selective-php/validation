<?php

namespace Selective\Validation\Test;

use Selective\Validation\ValidationError;
use Selective\Validation\ValidationResult;
use PHPUnit\Framework\TestCase;

/**
 * ValidationResult tests.
 *
 * @coversDefaultClass \Selective\Validation\ValidationResult
 */
class ValidationResultTest extends TestCase
{
    /**
     * Test instance.
     */
    public function testInstance()
    {
        $actual = new ValidationResult();
        $this->assertInstanceOf(ValidationResult::class, $actual);
    }

    /**
     * Tests getMessage and setMessage functions.
     *
     * @return void
     */
    public function testSetSuccessMessage()
    {
        $val = new ValidationResult();
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
        $val = new ValidationResult();
        $val->addError('error1', 'failed');
        $result = $val->isFailed();
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
        $val = new ValidationResult();
        $val->addError('', 'invalid');
        $result = $val->isFailed();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with an empty string for the second parameter.
     *
     * @return void
     */
    public function testErrorsWithField()
    {
        $val = new ValidationResult();
        $val->addError('field', 'message');
        $result = $val->isFailed();
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
        $val = new ValidationResult();
        $val->addError('email', 'required', '5000');
        $result = $val->isFailed();
        $this->assertTrue($result);
        $expected = ['field' => 'email', 'message' => 'required',  'code' => '5000'];
        $firstError = $val->getFirstError();

        $this->assertEquals($expected, $firstError ? $firstError->toArray() : null);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with null for the second parameter.
     *
     * @return void
     */
    public function testAddErrorMessage()
    {
        $val = new ValidationResult();
        $message = new ValidationError('required');
        $message->setField('email')->setCode('5000');

        $val->addValidationError($message);
        $result = $val->isFailed();
        $this->assertTrue($result);

        $expected = ['field' => 'email', 'message' => 'required',  'code' => '5000'];

        $firstError = $val->getFirstError();

        $this->assertEquals($expected, $firstError ? $firstError->toArray() : null);
    }

    /**
     * Tests success function.
     * Tests for no errors.
     *
     * @return void
     */
    public function testNoErrors()
    {
        $val = new ValidationResult();
        $result = $val->isFailed();
        $this->assertFalse($result);
    }

    /**
     * Tests __construct function.
     *
     * @return void
     */
    public function testGetMessage()
    {
        $val = new ValidationResult();
        $val->setMessage('Check your input');
        $this->assertSame('Check your input', $val->getMessage());

        $val->addError('error message', 'field');
        $this->assertSame('Check your input', $val->getMessage());
    }

    /**
     * Tests clear function.
     *
     * @return void
     */
    public function testClear()
    {
        $val = new ValidationResult();
        $val->setMessage('Errors');
        $val->addError('email', 'required');
        $val->clear();
        $result = $val->isFailed();
        $this->assertFalse($result);
    }

    /**
     * Tests getErrors function.
     *
     * @return void
     */
    public function testGetErrors()
    {
        $val = new ValidationResult();
        $errorFieldName = 'ERROR';
        $errorMessage = 'This is an error!';
        $val->addError($errorFieldName, $errorMessage);
        $result = $val->getErrors();
        $this->assertSame($result[0]->getField(), $errorFieldName);
        $this->assertSame($result[0]->getMessage(), $errorMessage);
        $this->assertNull($result[0]->getCode());
    }

    /**
     * Tests toArray function.
     *
     * @return void
     */
    public function testToArray()
    {
        $val = new ValidationResult();
        $val->setCode('error_code');
        $val->setMessage('Errors');
        $val->addError('error1', 'error');
        $val->addError('error2', 'error', '5000');
        $result = $val->toArray();
        $this->assertSame($result['code'], 'error_code');
        $this->assertSame($result['message'], 'Errors');
        $this->assertSame($result['errors'][0]['field'], 'error1');
        $this->assertSame($result['errors'][0]['message'], 'error');
        $this->assertSame($result['errors'][1]['field'], 'error2');
        $this->assertSame($result['errors'][1]['message'], 'error');
        $this->assertSame($result['errors'][1]['code'], '5000');
    }
}
