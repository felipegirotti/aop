<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 4:23 PM
 */

namespace Clickbus\Aop\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Psr\Log\LoggerInterface;
use Go\Lang\Annotation\Around;

class LogAspect implements Aspect
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }


    /**
     * @param MethodInvocation $invocation
     * @return mixed
     * @throws \Exception
     * @Around("@annotation(Clickbus\Aop\Annotation\Loggable)")
     */
    public function aroundLoggable(MethodInvocation $invocation)
    {
        $method = $this->getClassMethod($invocation);
        $this->logger->info("Entering " . $method, $invocation->getArguments());
        try {
            $result = $invocation->proceed();
            $resultString = is_scalar($result) ? $result : json_encode($result);
            $this->logger->info("Success: " . $method . ' - RESULT: ' . $resultString);
        } catch (\Exception $e) {
            $this->logger->error("Error: " . $method . ' details: ' . $e);
            throw $e;
        }
        return $result;
    }

    private function getClassMethod(MethodInvocation $invocation)
    {
        $obj   = $invocation->getThis();
        $class = is_object($obj) ? get_class($obj) : $obj;
        $method = $invocation->getMethod()->name;

        return $class . '::' . $method;
    }
} 