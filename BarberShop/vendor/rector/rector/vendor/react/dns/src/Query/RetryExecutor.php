<?php

namespace RectorPrefix20211231\React\Dns\Query;

use RectorPrefix20211231\React\Promise\CancellablePromiseInterface;
use RectorPrefix20211231\React\Promise\Deferred;
use RectorPrefix20211231\React\Promise\PromiseInterface;
final class RetryExecutor implements \RectorPrefix20211231\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $retries;
    public function __construct(\RectorPrefix20211231\React\Dns\Query\ExecutorInterface $executor, $retries = 2)
    {
        $this->executor = $executor;
        $this->retries = $retries;
    }
    public function query(\RectorPrefix20211231\React\Dns\Query\Query $query)
    {
        return $this->tryQuery($query, $this->retries);
    }
    public function tryQuery(\RectorPrefix20211231\React\Dns\Query\Query $query, $retries)
    {
        $deferred = new \RectorPrefix20211231\React\Promise\Deferred(function () use(&$promise) {
            if ($promise instanceof \RectorPrefix20211231\React\Promise\CancellablePromiseInterface || !\interface_exists('RectorPrefix20211231\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
                $promise->cancel();
            }
        });
        $success = function ($value) use($deferred, &$errorback) {
            $errorback = null;
            $deferred->resolve($value);
        };
        $executor = $this->executor;
        $errorback = function ($e) use($deferred, &$promise, $query, $success, &$errorback, &$retries, $executor) {
            if (!$e instanceof \RectorPrefix20211231\React\Dns\Query\TimeoutException) {
                $errorback = null;
                $deferred->reject($e);
            } elseif ($retries <= 0) {
                $errorback = null;
                $deferred->reject($e = new \RuntimeException('DNS query for ' . $query->describe() . ' failed: too many retries', 0, $e));
                // avoid garbage references by replacing all closures in call stack.
                // what a lovely piece of code!
                $r = new \ReflectionProperty('Exception', 'trace');
                $r->setAccessible(\true);
                $trace = $r->getValue($e);
                // Exception trace arguments are not available on some PHP 7.4 installs
                // @codeCoverageIgnoreStart
                foreach ($trace as &$one) {
                    if (isset($one['args'])) {
                        foreach ($one['args'] as &$arg) {
                            if ($arg instanceof \Closure) {
                                $arg = 'Object(' . \get_class($arg) . ')';
                            }
                        }
                    }
                }
                // @codeCoverageIgnoreEnd
                $r->setValue($e, $trace);
            } else {
                --$retries;
                $promise = $executor->query($query)->then($success, $errorback);
            }
        };
        $promise = $this->executor->query($query)->then($success, $errorback);
        return $deferred->promise();
    }
}
