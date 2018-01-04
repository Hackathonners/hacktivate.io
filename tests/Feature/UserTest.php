<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Alexa\Models\User;

class UserTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testUserCanEditHisProfile()
    {
        // Prepare
        $birthdate = Carbon::now()->subYears(20)->toDateString();

        $requestData = [
            'phone_number' => '915524851',
            'gender' => 'm',
            'birthdate' => $birthdate,
            'dietary_restrictions' => 'Don\'t have any dietary restrictions',
            'school' => 'University of Minho',
            'major' => 'Informatics',
            'study_level' => 'MsC',
            'special_needs' => 'Only love',
            'bio' => 'A very specific description',
        ];

        // Execute
        $response = $this->actingAs($this->user)
            ->put(route('users.update'), $requestData);

        // Assert
        $response->assertRedirect();
        $this->assertFalse(app('session.store')->has('errors'));
        $this->assertUserWasUpdated($requestData);
    }

    public function testAnUnderAgeUserCanNotEditHisProfile()
    {
        // Prepare
        $birthdate = Carbon::now()->subYears(15)->toDateString();

        $requestData = [
            'phone_number' => '915524851',
            'gender' => 'm',
            'birthdate' => $birthdate,
            'dietary_restrictions' => 'Don\'t have any dietary restrictions',
            'school' => 'University of Minho',
            'major' => 'Informatics',
            'study_level' => 'MsC',
            'special_needs' => 'Only love',
            'bio' => 'A very specific description',
        ];

        // Execute
        $response = $this->actingAs($this->user)
            ->put(route('users.update'), $requestData);

        // Assert
        $response->assertRedirect();
        $this->assertUserWasNotUpdated($requestData);
        $response->assertSessionHasErrors('birthdate');
    }

    /*
     * Assert user model was updated.
     */
    protected function assertUserWasUpdated(array $data)
    {
        $this->user->refresh();
        $this->assertEquals($data['phone_number'], $this->user->phone_number);
        $this->assertEquals($data['gender'], $this->user->gender);
        $this->assertEquals($data['birthdate'], $this->user->birthdate);
        $this->assertEquals($data['dietary_restrictions'], $this->user->dietary_restrictions);
        $this->assertEquals($data['school'], $this->user->school);
        $this->assertEquals($data['major'], $this->user->major);
        $this->assertEquals($data['study_level'], $this->user->study_level);
        $this->assertEquals($data['special_needs'], $this->user->special_needs);
        $this->assertEquals($data['bio'], $this->user->bio);
    }

    /*
     * Assert user model was not updated.
     */
    protected function assertUserWasNotUpdated(array $data)
    {
        $this->user->refresh();
        $this->assertNotEquals($data['phone_number'], $this->user->phone_number);
        $this->assertNotEquals($data['gender'], $this->user->gender);
        $this->assertNotEquals($data['birthdate'], $this->user->birthdate);
        $this->assertNotEquals($data['dietary_restrictions'], $this->user->dietary_restrictions);
        $this->assertNotEquals($data['school'], $this->user->school);
        $this->assertNotEquals($data['major'], $this->user->major);
        $this->assertNotEquals($data['study_level'], $this->user->study_level);
        $this->assertNotEquals($data['special_needs'], $this->user->special_needs);
        $this->assertNotEquals($data['bio'], $this->user->bio);
    }
}
