<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class CiviCrmInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('ext' => 'ext/{$name}/');
}
