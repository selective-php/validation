<?php

namespace Selective\Validation\Test\Factory;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Factory\CakeValidationFactory;
use Selective\Validation\ValidationError;

/**
 * Tests.
 */
class CakeValidationFactoryTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testCreateValidator()
    {
        (new CakeValidationFactory())->createValidator();

        $this->assertTrue(true);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateResultFromErrorsSimple()
    {
        $factory = new CakeValidationFactory();

        $errors = [
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
        ];

        $result = $factory->createValidationResult($errors);

        $errors = $result->getErrors();

        $errorList = [];
        foreach ($errors as $error) {
            $errorList[] = $this->toArray($error);
        }

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

        $this->assertEquals($expected, $errorList);
    }

    /**
     * Convert to array.
     *
     * @param ValidationError $error
     *
     * @return array Data
     */
    private function toArray(ValidationError $error): array
    {
        $result = [
            'message' => $error->getMessage(),
        ];

        $field = $error->getField();
        if ($field !== null) {
            $result['field'] = $field;
        }

        $code = $error->getCode();
        if ($code !== null) {
            $result['code'] = $code;
        }

        return $result;
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateResultFromErrorsNestedArray()
    {
        $factory = new CakeValidationFactory();

        $errors = [
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
        ];

        $result = $factory->createValidationResult($errors);

        $errors = $result->getErrors();

        $errorList = [];
        foreach ($errors as $error) {
            $errorList[] = $this->toArray($error);
        }
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

        $this->assertEquals($expected, $errorList);
    }
}
