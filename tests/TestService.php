<?php

namespace Odan\Validation\Test;

use Odan\Validation\ServiceResult;
use Odan\Validation\ValidationException;
use Odan\Validation\ValidationResult;

/**
 * Test service.
 */
class TestService
{
    /**
     * Process.
     *
     * @param int $id ID
     *
     * @throws ValidationException
     *
     * @return ServiceResult Result data
     */
    public function process(int $id): ServiceResult
    {
        $validation = new ValidationResult();

        if ($id < 1) {
            $validation->addError('id', 'invalid');
        }

        if ($validation->isFailed()) {
            $validation->setMessage('Please check your input');

            throw new ValidationException($validation);
        }

        $result = new ServiceResult();
        $result->setSuccess(true);
        $result->setMessage('Successfully');
        $result->setCode(0);
        $result->setResult(['foo' => 'value']);

        return $result;
    }
}
