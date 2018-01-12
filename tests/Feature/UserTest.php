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

        $this->user = factory(User::class)->create([
            'phone_number' => null,
            'gender' => 'o',
            'birthdate' => Carbon::now()->subYears(30)->toDateString(),
            'dietary_restrictions' => null,
            'school' => null,
            'major' => null,
            'study_level' => null,
            'special_needs' => null,
            'bio' => null,
        ]);
    }

    public function test_user_can_edit_his_profile()
    {
        // Prepare
        $requestData = [
            'phone_number' => '915524851',
            'gender' => 'm',
            'birthdate' => Carbon::now()->subYears(20)->toDateString(),
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

    public function test_an_under_age_user_can_not_edit_his_profile()
    {
        // Prepare
        $requestData = [
            'phone_number' => '915524851',
            'gender' => 'm',
            'birthdate' => Carbon::now()->subYears(15)->toDateString(),
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
        $user = $this->user->fresh();
        $this->assertEquals($user->phone_number, $this->user->phone_number);
        $this->assertEquals($user->gender, $this->user->gender);
        $this->assertEquals($user->birthdate, $this->user->birthdate);
        $this->assertEquals($user->dietary_restrictions, $this->user->dietary_restrictions);
        $this->assertEquals($user->school, $this->user->school);
        $this->assertEquals($user->major, $this->user->major);
        $this->assertEquals($user->study_level, $this->user->study_level);
        $this->assertEquals($user->special_needs, $this->user->special_needs);
        $this->assertEquals($user->bio, $this->user->bio);
    }
}
