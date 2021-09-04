<?php

namespace Selective\Validation\Test\Converter;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Converter\CakeValidationValidationConverter;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Selective\Validation\ValidationResult;

/**
 * Tests.
 */
class CakeValidationFactoryTest extends TestCase
{
    /**
     * Convert validation details to array.
     *
     * @param ValidationResult $validationResult The result
     *
     * @return array The array
     */
    private function getValidationResultAsArray(ValidationResult $validationResult): array
    {
        return (new ErrorDetailsResultTransformer())->transform($validationResult)['error']['details'];
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateResultFromErrorsSimple()
    {
        $result = (new CakeValidationValidationConverter())->createValidationResult([
            'first_name' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'last_name' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'gender' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'date_of_birth' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'country' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'city' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'postal_code' => [
                '_empty' => 'This field cannot be left empty',
            ],
            'street' => [
                '_empty' => 'This field cannot be left empty',
            ],
        ]);

        $errors = $this->getValidationResultAsArray($result);
        $expected = [
            0 => [
                'message' => 'This field cannot be left empty',
                'field' => 'first_name',
            ],
            1 => [
                'message' => 'This field cannot be left empty',
                'field' => 'last_name',
            ],
            2 => [
                'message' => 'This field cannot be left empty',
                'field' => 'gender',
            ],
            3 => [
                'message' => 'This field cannot be left empty',
                'field' => 'date_of_birth',
            ],
            4 => [
                'message' => 'This field cannot be left empty',
                'field' => 'country',
            ],
            5 => [
                'message' => 'This field cannot be left empty',
                'field' => 'city',
            ],
            6 => [
                'message' => 'This field cannot be left empty',
                'field' => 'postal_code',
            ],
            7 => [
                'message' => 'This field cannot be left empty',
                'field' => 'street',
            ],
        ];

        $this->assertEquals($expected, $errors);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateResultFromErrorsNestedArray()
    {
        $result = (new CakeValidationValidationConverter())->createValidationResult([
            'bills' => [
                0 => [
                    'billing_number' => [
                        '_required' => 'This field is required',
                    ],
                    'billing_date' => [
                        '_required' => 'This field is required',
                    ],
                    'billing_period' => [
                        'start' => [
                            'regex' => 'The provided value is invalid',
                        ],
                        'end' => [
                            'regex' => 'The provided value is invalid',
                        ],
                    ],
                    'chauffeur' => [
                        'number' => [
                            '_required' => 'This field is required',
                        ],
                        'name' => [
                            '_required' => 'This field is required',
                        ],
                    ],
                ],
            ],
        ]);

        $errors = $this->getValidationResultAsArray($result);
        $expected = [
            0 => [
                'message' => 'This field is required',
                'field' => 'bills.0.billing_number',
            ],
            1 => [
                'message' => 'This field is required',
                'field' => 'bills.0.billing_date',
            ],
            2 => [
                'message' => 'The provided value is invalid',
                'field' => 'bills.0.billing_period.start',
            ],
            3 => [
                'message' => 'The provided value is invalid',
                'field' => 'bills.0.billing_period.end',
            ],
            4 => [
                'message' => 'This field is required',
                'field' => 'bills.0.chauffeur.number',
            ],
            5 => [
                'message' => 'This field is required',
                'field' => 'bills.0.chauffeur.name',
            ],
        ];

        $this->assertEquals($expected, $errors);
    }
}
