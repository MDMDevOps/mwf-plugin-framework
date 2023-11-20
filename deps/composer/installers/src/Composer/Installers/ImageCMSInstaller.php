<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class ImageCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('template' => 'templates/{$name}/', 'module' => 'application/modules/{$name}/', 'library' => 'application/libraries/{$name}/');
}
