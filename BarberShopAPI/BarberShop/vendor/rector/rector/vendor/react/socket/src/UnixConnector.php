<?php

namespace RectorPrefix20211231\React\Socket;

use RectorPrefix20211231\React\EventLoop\Loop;
use RectorPrefix20211231\React\EventLoop\LoopInterface;
use RectorPrefix20211231\React\Promise;
use InvalidArgumentException;
use RuntimeException;
/**
 * Unix domain socket connector
 *
 * Unix domain sockets use atomic operations, so we can as well emulate
 * async behavior.
 */
final class UnixConnector implements \RectorPrefix20211231\React\Socket\ConnectorInterface
{
    private $loop;
    public function __construct(\RectorPrefix20211231\React\EventLoop\LoopInterface $loop = null)
    {
        $this->loop = $loop ?: \RectorPrefix20211231\React\EventLoop\Loop::get();
    }
    public function connect($path)
    {
        if (\strpos($path, '://') === \false) {
            $path = 'unix://' . $path;
        } elseif (\substr($path, 0, 7) !== 'unix://') {
            return \RectorPrefix20211231\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $path . '" is invalid (EINVAL)', \defined('SOCKET_EINVAL') ? \SOCKET_EINVAL : 22));
        }
        $resource = @\stream_socket_client($path, $errno, $errstr, 1.0);
        if (!$resource) {
            return \RectorPrefix20211231\React\Promise\reject(new \RuntimeException('Unable to connect to unix domain socket "' . $path . '": ' . $errstr . \RectorPrefix20211231\React\Socket\SocketServer::errconst($errno), $errno));
        }
        $connection = new \RectorPrefix20211231\React\Socket\Connection($resource, $this->loop);
        $connection->unix = \true;
        return \RectorPrefix20211231\React\Promise\resolve($connection);
    }
}
