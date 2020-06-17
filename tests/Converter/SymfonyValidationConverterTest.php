<?php

namespace Selective\Validation\Test\Converter;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Converter\SymfonyValidationConverter;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Tests.
 */
class SymfonyValidationConverterTest extends TestCase
{
    /**
     * Test.
     */
    public function testCreateValidationResult(): void
    {
        $violations = new ConstraintViolationList();
        $violations->add(new ConstraintViolation('Email required', null, [], '', 'email', ''));

        $result = SymfonyValidationConverter::createValidationResult($violations);

        $this->assertEquals(true, $result->isFailed());
        $this->assertEquals('Email required', $result->getErrors()[0]->getMessage());
        $this->assertEquals('email', $result->getErrors()[0]->getField());
        $this->assertEquals(null, $result->getErrors()[0]->getCode());
    }
}
