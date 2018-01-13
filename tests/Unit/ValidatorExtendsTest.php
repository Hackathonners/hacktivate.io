<?php

namespace Tests\Unit;

use Validator;
use Tests\TestCase;

class ValidatorExtendsTest extends TestCase
{
    public function testValidatorMaxField()
    {
        // Prepare
        $rules = [
          'test_input' => 'numeric|max_field:max_input',
        ];

        // Execute
        $validatorPasses = Validator::make([
          'test_input' => 2,
          'max_input' => 3,
        ], $rules);

        $validatorFails = Validator::make([
          'test_input' => 4,
          'max_input' => 3,
        ], $rules);

        // Assert
        $this->assertTrue($validatorPasses->passes());
        $this->assertTrue($validatorFails->fails());
    }

    public function testValidatorMinField()
    {
        // Prepare
        $rules = [
          'test_input' => 'numeric|min_field:min_input',
        ];

        // Execute
        $validatorPasses = Validator::make([
          'test_input' => 4,
          'min_input' => 3,
        ], $rules);

        $validatorFails = Validator::make([
          'test_input' => 2,
          'min_input' => 3,
        ], $rules);

        // Assert
        $this->assertTrue($validatorPasses->passes());
        $this->assertTrue($validatorFails->fails());
    }
}
