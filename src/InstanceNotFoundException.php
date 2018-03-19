<?php

namespace Nasqueron\SAAS;

use Throwable;

class InstanceNotFoundException extends SaaSException {

    /**
     * @var string
     */
    private $instance;

    /**
     * @var string
     */
    const DEFAULT_MESSAGE = "The specified instance can't been found.";

    public function __construct (string $instance, string $message = "",
                                 int $code = 0, Throwable $previous = null) {
        $this->instance = $instance;

        if ($message === "") {
            $message = self::DEFAULT_MESSAGE;
        }

        parent::__construct($message, $code, $previous);
    }

    public function getInstance () : string {
        return $this->instance;
    }

    public function setInstance (string $instance) : void {
        $this->instance = $instance;
    }

}
