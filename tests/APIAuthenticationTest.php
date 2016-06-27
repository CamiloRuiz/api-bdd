<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIAuthenticationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Test the route for authentication through the API with invalid credentials and verifies both content and statusof the response.
     *
     * @return void
     */
    public function testInvalidCredentials()
    {
        $invalid_credentials = array(
            'email' => 'cristian@takum.co',
            'password' => 'testing'
        );

        $expected_json_content = array(
            'error' => 'invalid_credentials',
        );

        $this->json('POST', '/auth', $invalid_credentials)
                ->assertResponseStatus(401)
                ->seeJson($expected_json_content);
    }

    /**
     * Test the route for authentication through the API with valid credentials and verifies both content and statusof the response.
     *
     * @return void
     */
    public function testValidCredentials()
    {
        # Preparing the data
        $rand_pass = str_random(12);
        $user = factory(App\Models\User::class, 'user')->create([
            'password' => bcrypt($rand_pass)
        ]);

        $valid_credentials = array(
            'email' => $user->email,
            'password' => $rand_pass
        );

        # This is whow the content should look.
        $expected_json_structure = array(
            'token',
            'user' => [
                'firstname',
                'lastname',
                'email',
                'picture_url'
            ]
        );

        $this->json('POST', '/auth', $valid_credentials)
                ->assertResponseOk()
                ->seeJsonStructure($expected_json_structure);
    }
}
