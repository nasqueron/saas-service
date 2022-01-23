<?php

namespace Nasqueron\SAAS;

abstract class Service {

    ///
    /// Request methods
    ///

    public function handleNotExistingSite() : Service {
        if (!$this->isExisting()) {
            $this->serveNotExistingResponse();
        }

        return $this;
    }

    /**
     * @throws SaasException where the URI can't be found
     */
    public function handleAliveRequest() : Service {
        // Handles /status requests
        if (self::isAliveRequest()) {
            $this->serveAliveResponse();
        }

        return $this;
    }

    public abstract function run();

    ///
    /// Default implementation
    ///

    public function isExisting () : bool {
        return true;
    }

    public function serveAliveResponse() : void {
        die("ALIVE");
    }

    public function serveNotExistingResponse(): void {
        header("HTTP/1.0 404 Not Found");
        die("This site doesn't exist.");
    }

    ///
    /// Helper methods
    ///

    public static function getServerHost() : string {
        if (isset($_SERVER['HTTP_HOST'])) {
            return self::extractHost($_SERVER['HTTP_HOST']);
        }

        return "";
    }

    /**
     * Extracts host from a host:port expression
     *
     * @param string $expression The host:port expression, e.g. acme.domain.tld:5000
     * @return string The host expression without the port, e.g. acme.domain.tld
     */
    private static function extractHost (string $expression) : string {
        $position = strpos($expression, ':');

        if ($position === false) {
            return $expression;
        }

        return substr ($expression, 0, $position);
    }

    /**
     * @throws SaasException when no URL server parameter have been found.
     */
    public static function getUri() : string {
        $sources = [
            'DOCUMENT_URI',
            'REQUEST_URI',
        ];

        foreach ($sources as $source) {
            if (isset($_SERVER[$source])) {
                return $_SERVER[$source];
            }
        }

        throw new SaasException("Can't get URI.");
    }

    /**
     * @throws SaasException where the URI can't be found
     */
    private static function isAliveRequest() : bool {
        return
            array_key_exists('REQUEST_METHOD', $_SERVER)
        &&
            ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'HEAD')
        &&
            static::getUri() === '/status';
    }

}
