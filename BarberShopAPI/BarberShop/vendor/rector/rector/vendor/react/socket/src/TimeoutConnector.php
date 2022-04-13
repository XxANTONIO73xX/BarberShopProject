<?php

namespace RectorPrefix20211231\React\Socket;

use RectorPrefix20211231\React\EventLoop\Loop;
use RectorPrefix20211231\React\EventLoop\LoopInterface;
use RectorPrefix20211231\React\Promise\Timer;
use RectorPrefix20211231\React\Promise\Timer\TimeoutException;
final class TimeoutConnector implements \RectorPrefix20211231\React\Socket\ConnectorInterface
{
    private $connector;
    private $timeout;
    private $loop;
    public function __construct(\RectorPrefix20211231\React\Socket\ConnectorInterface $connector, $timeout, \RectorPrefix20211231\React\EventLoop\LoopInterface $loop = null)
    {
        $this->connector = $connector;
        $this->timeout = $timeout;
        $this->loop = $loop ?: \RectorPrefix20211231\React\EventLoop\Loop::get();
    }
    public function connect($uri)
    {
        return \RectorPrefix20211231\React\Promise\Timer\timeout($this->connector->connect($uri), $this->timeout, $this->loop)->then(null, self::handler($uri));
    }
    /**
     * Creates a static rejection handler that reports a proper error message in case of a timeout.
     *
     * This uses a private static helper method to ensure this closure is not
     * bound to this instance and the exception trace does not include a
     * reference to this instance and its connector stack as a result.
     *
     * @param string $uri
     * @return callable
     */
    private static function handler($uri)
    {
        return function (\Exception $e) use($uri) {
            if ($e instanceof \RectorPrefix20211231\React\Promise\Timer\TimeoutException) {
                throw new \RuntimeException('Connection to ' . $uri . ' timed out after ' . $e->getTimeout() . ' seconds (ETIMEDOUT)', \defined('SOCKET_ETIMEDOUT') ? \SOCKET_ETIMEDOUT : 110);
            }
            throw $e;
        };
    }
}
