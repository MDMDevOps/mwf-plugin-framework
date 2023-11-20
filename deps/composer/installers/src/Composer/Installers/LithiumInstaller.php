<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class LithiumInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('library' => 'libraries/{$name}/', 'source' => 'libraries/_source/{$name}/');
}