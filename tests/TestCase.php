<?php
namespace Txd\Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Txd\Provider\FormsServiceProvider;

class TestCase extends FrameworkTestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        
      FormsServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}