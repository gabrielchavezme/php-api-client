<?php
namespace Mifiel\Tests\Integration;

use Mifiel\ApiClient,
    Mifiel\Certificate;

class CertificateCRUDTest {

  private static $id;

  public function getCertificate() {
    ApiClient::setTokens(
      '385d67ed1271279d521154b28e238af8683272fe',
      'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA=='
    );
    ApiClient::url('https://sandbox.mifiel.com/api/v1/');
    $certificates = Certificate::all();
    return end($certificates);
  }

  /**
   * @group internet
   */
  public function testCreate() {
    $this->setTokens();
    $certificate = new Certificate([
      'file_path' => './tests/fixtures/FIEL_AAA010101AAA.cer'
    ]);
    $certificate->save();
    self::$id = $certificate->id;
    // Fetch document again
    $certificate = $this->getCertificate();
    $this->assertEquals(self::$id, $certificate->id);
  }

  /**
   * @group internet
   */
  public function testAll() {
    $this->setTokens();
    $certificates = Certificate::all();
    var_dump($certificates);
    $this->assertTrue(is_array($certificates));
    $this->assertEquals('Mifiel\Certificate', get_class(reset($certificates)));
  }

  /**
   * @group internet
   */
  public function testGetProperties() {
    $certificate = $this->getCertificate();
    $this->assertEquals(self::$id, $certificate->id);
  }

  /**
   * @group internet
   */
  public function testSetProperties() {
    $certificate = $this->getCertificate();
    $this->assertEquals('20001000000200001410', $certificate->certificate_number);

    $certificate_number = 'blah';
    $certificate->certificate_number = $certificate_number;
    $this->assertEquals($certificate_number, $certificate->certificate_number);
  }

  /**
   * @group internet
   */
  public function testDelete() {
    $certificate = $this->getCertificate();
    if ($certificate)
      Certificate::delete($certificate->id);
    $certificates = Certificate::all();
    $this->assertEmpty($certificates);
  }

}
