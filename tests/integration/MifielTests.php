<?php
// read http://www.sitepoint.com/unit-testing-guzzlephp/
// for testing without server
namespace Mifiel\Tests\Integration;

use Mifiel\ApiClient as Mifiel;
use PHPUnit\Framework\TestCase;

class MifielTests extends TestCase {

  public function setTokens() {
    Mifiel::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    Mifiel::url('https://sandbox.mifiel.com/api/v1/');
  }
}
