<?php

namespace Nasqueron\SAAS\Tests\Mocks;

use Nasqueron\SAAS\Service;

class TestService extends Service {

    /**
     * @var string
     */
    private $host;

    public function __construct (string $host = '') {
        $this->host = $host;
    }

    public function run () : void {
    }

    public function isExisting () : bool {
        return $this->host === "service.acme.tld";
    }

}
