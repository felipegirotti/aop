<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 2:44 PM
 */

namespace Clickbus\Aop\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 *
 * @property int $minutesToExpire
 */
final class Cacheable extends Annotation
{
    public $minutesToExpire = 60;
} 