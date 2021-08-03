<?php
namespace Mifiel\Tests\Integration;

use Mifiel\ApiClient,
    Mifiel\User;

class UserTest {

  /**
   * @group internet
   */
  public function testCreateUser() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $user = new User([
      'email' => 'some'.rand(1000).'@gmail.com'
    ]);
    $user->save();
    $this->assertEquals(null, $user->message);
    $this->assertEquals('success', $user->status);
  }
}
