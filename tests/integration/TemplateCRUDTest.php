<?php
namespace Mifiel\Tests\Integration;

use Mifiel\ApiClient,
    Mifiel\Template;

class TemplateCRUDTest {
  private static $id;

  public function getTemplate() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $templates = Template::all();
    return reset($templates);
  }

  /**
   * @group internet
   */
  public function testCreate() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $template = new Template([
      'name' => 'some template name',
      'content' => '<field name="some">SOME</field>'
    ]);
    $template->save();
    self::$id = $template->id;
    // Fetch template again
    $template = $this->getTemplate();
    $this->assertEquals(self::$id, $template->id);
  }

  /**
   * @group internet
   */
  public function testSaveUpdate() {
    $template = $this->getTemplate();
    $this->assertEquals('some template name', $template->name);
    $name = 'blah';
    $template->name = $name;
    $template->save();
    // Fetch template again
    $template = $this->getTemplate();
    $this->assertEquals($name, $template->name);
  }

    /**
   * @group internet
   */
  public function testAll() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $templates = Template::all();
    $this->assertTrue(is_array($templates));
    $this->assertEquals('Mifiel\Template', get_class(reset($templates)));
  }

  /**
   * @group internet
   */
  public function testDelete() {
    $template = $this->getTemplate();
    if ($template)
      Template::delete($template->id);
    $templates = Template::all();
    $this->assertEmpty($templates);
  }
}
