<?php
declare(strict_types=1);

namespace Nasqueron\SAAS\Tests;

use Nasqueron\SAAS\InstanceNotFoundException;
use PHPUnit\Framework\TestCase;

final class InstanceNotFoundTest extends TestCase {

    /**
     * @var \Nasqueron\SAAS\InstanceNotFoundException
     */
    private $exception;

    protected function setUp () {
        $this->exception = new InstanceNotFoundException("foo");
    }

    public function testGetInstance () {
        $this->assertEquals("foo", $this->exception->getInstance());
    }

    public function testSetInstance () {
        $this->exception->setInstance("bar");
        $this->assertEquals("bar", $this->exception->getInstance());
    }
}
