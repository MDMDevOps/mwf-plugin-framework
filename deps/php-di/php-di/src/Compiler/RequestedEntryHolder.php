<?php

declare (strict_types=1);
namespace Mwf\Lib\Deps\DI\Compiler;

use Mwf\Lib\Deps\DI\Factory\RequestedEntry;
/**
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
class RequestedEntryHolder implements RequestedEntry
{
    public function __construct(private string $name)
    {
    }
    public function getName() : string
    {
        return $this->name;
    }
}
