<?php

namespace Selective\Validation\Test\Transformer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Selective\Validation\ValidationResult;

/**
 * Tests.
 */
#[CoversClass(ErrorDetailsResultTransformer::class)]
class ErrorDetailsTransformerTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testTransform(): void
    {
        $transformer = new ErrorDetailsResultTransformer();

        $validationResult = new ValidationResult();
        $actual = $transformer->transform($validationResult);
        $this->assertSame(['error' => []], $actual);

        $validationResult = new ValidationResult();
        $validationResult->addError('email', 'required', '100');
        $actual = $transformer->transform($validationResult);

        $expected = [
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

        $this->assertSame($expected, $actual);
    }
}
