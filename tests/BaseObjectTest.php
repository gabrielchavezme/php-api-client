<?php
namespace Mifiel\Tests;

use Mifiel\ApiClient,
    Mifiel\BaseObject,
    Mifiel\ArgumentError;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class BaseObjectTest extends TestCase {
  public function testCheckRequiredArgsOK() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => 'blah1',
      'arg' => ['some' => 'arg']
    ];
    $resp = BaseObject::checkRequiredArgs($required, $args);
    $this->assertEquals($resp, true);
  }

  public function testCheckRequiredArgsRequired() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => 'blah1'
    ];
    $this->expectException('Mifiel\ArgumentError');
    BaseObject::checkRequiredArgs($required, $args);
  }

  /**
   * @expectedException        Mifiel\ArgumentError
   * @expectedExceptionMessage Param 'other' must be 'string'
   */
  public function testCheckRequiredArgsWrongType() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => ['blah1'],
      'arg' => ['some']
    ];
    BaseObject::checkRequiredArgs($required, $args);
  }
}
