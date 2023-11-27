<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class ClanCatsFrameworkInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('ship' => 'CCF/orbit/{$name}/', 'theme' => 'CCF/app/themes/{$name}/');
}
