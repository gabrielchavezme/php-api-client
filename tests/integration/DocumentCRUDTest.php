<?php
namespace Mifiel\Tests\Integration;

use Mifiel\ApiClient,
    Mifiel\Document;

class DocumentCRUDTest extends MifielTests {

  const ORIGINAL_HASH = 'f4dee35b52fc06aa9d47f6297c7cff51e8bcebf90683da234a07ed507dafd57b';
  private static $id;

  public function getDocument() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    if (self::$id) {
      return Document::find(self::$id);
    }
    $documents = Document::all();
    return reset($documents);
  }

  /**
   * @group internet
   */
  public function testSaveCreate() {
   ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $document = new Document([
      'original_hash' => self::ORIGINAL_HASH,
      'name' => 'some.pdf',
      'signatories' => [
        [ 'email' => 'paco@mifiel.com' ],
        [ 'email' => 'pedro@mifiel.com' ]
      ]
    ]);
    $document->save();
    self::$id = $document->id;
    // Fetch document again
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testSaveDocCreate() {
   ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $document = new Document([
      'file_path' => './tests/fixtures/example.pdf',
    ]);
    $document->save();
    self::$id = $document->id;
    // Fetch document again
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testSaveFile() {
   ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $document = $this->getDocument();
    $path = 'tmp/the-file.pdf';
    $document->saveFile($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveFileSigned() {
   ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $document = $this->getDocument();
    $path = 'tmp/the-file-signed.pdf';
    $document->saveFileSigned($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveXml() {
   ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $document = $this->getDocument();
    $path = 'tmp/the-file.xml';
    $document->saveXml($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveUpdate() {
    $document = $this->getDocument();
    $this->assertEquals('', $document->callback_url);
    $callback_url = 'http://blah.com';
    $document->callback_url = $callback_url;
    $document->save();
    // Fetch document again
    $document = $this->getDocument();
    $this->assertEquals($callback_url, $document->callback_url);
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
    $documents = Document::all();
    $this->assertTrue(is_array($documents));
    $this->assertEquals('Mifiel\Document', get_class(reset($documents)));
  }

  /**
   * @group internet
   */
  public function testGetProperties() {
    $document = $this->getDocument();
    $this->assertEquals(self::$id, $document->id);
  }

  /**
   * @group internet
   */
  public function testSetProperties() {
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);

    $original_hash = 'blah';
    $document->original_hash = $original_hash;
    $this->assertEquals($original_hash, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testDelete() {
    $documents = Document::all();
    foreach ($documents as $document) {
      Document::delete($document->id);
    }
    $documents = Document::all();
    $this->assertEmpty($documents);
  }
}
