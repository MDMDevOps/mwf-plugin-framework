<?php

namespace Mwf\Lib\Deps\Timber;

/**
 * Interface CoreInterface
 * @internal
 */
interface CoreInterface
{
    public function __call($field, $args);
    public function __get($field);
    /**
     * @return boolean
     */
    public function __isset($field);
}
