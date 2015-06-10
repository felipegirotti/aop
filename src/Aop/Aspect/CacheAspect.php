<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 2:50 PM
 */

namespace Clickbus\Aop\Aspect;

use Clickbus\Aop\Annotation\Cacheable;
use Clickbus\Cache\CacheService;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

class CacheAspect implements Aspect
{

    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @param MethodInvocation $invocation Invocation
     * @Around("@annotation(Clickbus\Aop\Annotation\Cacheable)")
     *
     * @return mixed
     */
    public function aroundCacheable(MethodInvocation $invocation)
    {
        /** @var Cacheable $cacheableAnnotation */
        $cacheableAnnotation = $invocation->getMethod()->getAnnotation('Clickbus\Aop\Annotation\Cacheable');

        $key = $this->getUniqueKey($invocation);

        if ( ! $this->cacheService->has($key)) {
            $this->cacheService->save($key, $invocation->proceed(), $cacheableAnnotation->minutesToExpire);
        }

        return $this->cacheService->get($key);
    }

    private function getUniqueKey(MethodInvocation $invocation) {

        $obj   = $invocation->getThis();
        $class = is_object($obj) ? get_class($obj) : $obj;
        $arguments = json_encode($invocation->getArguments());

        $key   = $class . ':' . $invocation->getMethod()->name . ':' . $arguments;

        return $key;
    }


}
