<?php
declare(strict_types=1);

namespace Nasqueron\SAAS\Tests;

use Nasqueron\SAAS\SaaSException;
use Nasqueron\SAAS\Service;
use Nasqueron\SAAS\Tests\Mocks\TestService;
use PHPUnit\Framework\TestCase;

final class ServiceTest extends TestCase {

    /**
     * @var \Nasqueron\SAAS\Service
     */
    private $service;

    /**
     * @var \Nasqueron\SAAS\Service
     */
    private $notExistingService;

    protected function setUp() {
        $this->service = new TestService("service.acme.tld");
        $this->notExistingService = new TestService("bipbip.acme.tld");
    }

    public function testIsExisting() {
        $this->assertTrue($this->service->isExisting());
        $this->assertFalse($this->notExistingService->isExisting());
    }

    /**
     * @dataProvider hostProvider
     */
    public function testGetServerHost($host, $expected) {
        $_SERVER["HTTP_HOST"] = $host;
        $this->assertEquals($expected, Service::getServerHost());
    }

    public function hostProvider () : iterable {
        yield ["service.acme.tld", "service.acme.tld"];
        yield ["service.acme.tld:1234", "service.acme.tld"];
        yield ["127.0.0.1", "127.0.0.1"];
        yield ["127.0.0.1:1234", "127.0.0.1"];
        yield ["", ""];
        yield [":1234", ""];
    }

    public function testGetUriForNginxServer () {
        $_SERVER['REQUEST_URI'] = "/foo";
        $this->assertEquals("/foo", Service::getUri());
    }

    public function testGetUriForInternalPHPServer () {
        $_SERVER['DOCUMENT_URI'] = "/foo";
        $this->assertEquals("/foo", Service::getUri());
    }

    public function testGetUriWhenThereIsNot () {
        unset($_SERVER['DOCUMENT_URI']);
        unset($_SERVER['REQUEST_URI']);

        $this->expectException(SaasException::class);
    }
}
