<?php

declare (strict_types=1);
namespace Mwf\Lib\Deps\DI;

use Psr\Container\ContainerExceptionInterface;
/**
 * Exception for the Container.
 * @internal
 */
class DependencyException extends \Exception implements ContainerExceptionInterface
{
}
