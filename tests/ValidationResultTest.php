<?php

namespace Selective\Validation\Test;

use PHPUnit\Framework\TestCase;
use Selective\Validation\ValidationError;
use Selective\Validation\ValidationResult;

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
    public function testInstance(): void
    {
        $actual = new ValidationResult();
        $this->assertInstanceOf(ValidationResult::class, $actual);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with two strings.
     */
    public function testErrors(): void
    {
        $val = new ValidationResult();
        $val->addError('error1', 'failed');
        $result = $val->fails();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with an empty string for the first parameter.
     */
    public function testErrorsEmptyFieldOne(): void
    {
        $val = new ValidationResult();
        $val->addError('', 'invalid');
        $result = $val->fails();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with an empty string for the second parameter.
     */
    public function testErrorsWithField(): void
    {
        $val = new ValidationResult();
        $val->addError('field', 'message');
        $result = $val->fails();
        $this->assertTrue($result);
    }

    /**
     * Tests addError and success functions.
     * Tests addError function with null for the second parameter.
     */
    public function testErrorsWithMessage(): void
    {
        $val = new ValidationResult();
        $val->addError('email', 'required', '5000');
        $result = $val->fails();
        $this->assertTrue($result);

        $firstError = $val->getFirstError();
        $this->assertInstanceOf(ValidationError::class, $firstError);
        $this->assertSame('email', $firstError->getField());
        $this->assertSame('required', $firstError->getMessage());
        $this->assertSame('5000', $firstError->getCode());
    }

    /**
     * Tests success function.
     * Tests for no errors.
     */
    public function testNoErrors(): void
    {
        $val = new ValidationResult();
        $result = $val->fails();
        $this->assertFalse($result);
    }

    /**
     * Tests clear function.
     */
    public function testClear(): void
    {
        $val = new ValidationResult();
        $val->addError('email', 'required');
        $val->clear();
        $result = $val->fails();
        $this->assertFalse($result);
    }

    /**
     * Tests getErrors function.
     */
    public function testGetErrors(): void
    {
        $val = new ValidationResult();
        $errorFieldName = 'ERROR';
        $errorMessage = 'This is an error!';
        $val->addError($errorFieldName, $errorMessage);
        $result = $val->getErrors()[0];
        $this->assertSame($errorFieldName, $result->getField());
        $this->assertSame($errorMessage, $result->getMessage());
        $this->assertNull($result->getCode());
    }
}
