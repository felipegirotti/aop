<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 2:29 PM
 */

namespace Clickbus;

use Clickbus\Aop\Aspect\CacheAspect;
use Clickbus\Aop\Aspect\LogAspect;
use Go\Core\AspectKernel;
use Go\Core\AspectContainer;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel
{

    protected $containerApp;

    public function setContainer($container)
    {
        $this->containerApp = $container;
    }

    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        $cache = $this->containerApp->get('cache.service');
        $logger = $this->containerApp->get('logger');
        $container->registerAspect(new CacheAspect($cache));
        $container->registerAspect(new LogAspect($logger));
    }
}