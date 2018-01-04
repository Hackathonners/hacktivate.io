<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Alexa\Models\User;

class UserTest extends TestCase
{
    public function testUserCanEditIsProfile()
    {
        // Prepare
        $user = factory(User::class)->create();

        $requestData = [
            'phone_number' => '915524851',
            'gender' => 'm',
            'birthdate' => '1990-12-22',
            'dietary_restrictions' => 'Don\'t have any dietary restrictions',
            'school' => 'University of Minho',
            'major' => 'Informatics',
            'study_level' => 'MsC',
            'special_needs' => 'Only love',
            'bio' => 'A very specific description',
        ];

        // Execute
        $response = $this->actingAs($user)
            ->put(route('users.update'), $requestData);

        // Assert
        $user->refresh();
        $response->assertRedirect();
        $this->assertFalse(app('session.store')->has('errors'));
        $this->assertEquals($requestData['phone_number'], $user->phone_number);
        $this->assertEquals($requestData['gender'], $user->gender);
        $this->assertEquals($requestData['birthdate'], $user->birthdate);
        $this->assertEquals($requestData['dietary_restrictions'], $user->dietary_restrictions);
        $this->assertEquals($requestData['school'], $user->school);
        $this->assertEquals($requestData['major'], $user->major);
        $this->assertEquals($requestData['study_level'], $user->study_level);
        $this->assertEquals($requestData['special_needs'], $user->special_needs);
        $this->assertEquals($requestData['bio'], $user->bio);
    }
}
