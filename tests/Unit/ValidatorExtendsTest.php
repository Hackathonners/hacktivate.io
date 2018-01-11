<?php

namespace Tests\Unit;

use Validator;
use Tests\TestCase;

class ValidatorExtendsTest extends TestCase
{
    public function testValidatorMaxField()
    {
        $rules = [
          'testField' => 'numeric|max_field:maxField',
        ];
        $passesField = 2;
        $failsField = 4;
        $maxField = 3;

        $validatorPasses = Validator::make([
          'testField' => $passesField,
          'maxField' => $maxField,
        ], $rules);
        $validatorFails = Validator::make([
          'testField' => $failsField,
          'maxField' => $maxField,
        ], $rules);

        $this->assertTrue($validatorPasses->passes());
        $this->assertTrue($validatorFails->fails());
    }

    public function testValidatorMinField()
    {
        $rules = [
          'testField' => 'numeric|min_field:minField',
        ];
        $passesField = 4;
        $failsField = 2;
        $minField = 3;

        $validatorPasses = Validator::make([
          'testField' => $passesField,
          'minField' => $minField,
        ], $rules);
        $validatorFails = Validator::make([
          'testField' => $failsField,
          'minField' => $minField,
        ], $rules);

        $this->assertTrue($validatorPasses->passes());
        $this->assertTrue($validatorFails->fails());
    }
}
