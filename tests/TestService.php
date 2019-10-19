<?php

namespace Selective\Validation\Test;

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

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
     * @return array Result data
     */
    public function process(int $id): array
    {
        $validation = new ValidationResult();

        if ($id < 1) {
            $validation->addError('id', 'invalid');
        }

        if ($validation->isFailed()) {
            $validation->setMessage('Please check your input');

            throw new ValidationException($validation);
        }

        $result = [];
        $result['success'] = true;
        $result['message'] = 'Successfully';
        $result['code'] = 0;
        $result['data']['foo'] = 'value';

        return $result;
    }
}
