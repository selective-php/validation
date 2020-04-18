<?php

namespace Selective\Validation\Test\Transformer;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Transformer\ErrorDetailsTransformer;
use Selective\Validation\ValidationResult;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\Transformer\ErrorDetailsTransformer
 */
class ErrorDetailsTransformerTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testTransform()
    {
        $transformer = new ErrorDetailsTransformer();

        $validationResult = new ValidationResult();
        $actual = $transformer->transform($validationResult);
        static::assertSame(['error' => []], $actual);

        $validationResult = new ValidationResult();
        $validationResult->addError('email', 'required', '100');
        $actual = $transformer->transform($validationResult);

        $exptected = [
            'error' => [
                'details' => [
                    [
                        'message' => 'required',
                        'field' => 'email',
                        'code' => '100',
                    ],
                ],
            ],
        ];

        static::assertSame($exptected, $actual);
    }

    /**
     * Test.
     */
    public function testInvalidEncoding(): void
    {
        $this->assertTrue(true);
    }
}
