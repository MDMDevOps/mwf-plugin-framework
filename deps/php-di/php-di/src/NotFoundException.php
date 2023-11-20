<?php

declare (strict_types=1);
namespace Mwf\Lib\Deps\DI;

use Mwf\Lib\Deps\Psr\Container\NotFoundExceptionInterface;
/**
 * Exception thrown when a class or a value is not found in the container.
 * @internal
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
