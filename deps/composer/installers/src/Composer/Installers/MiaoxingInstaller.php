<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class MiaoxingInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('plugin' => 'plugins/{$name}/');
}
