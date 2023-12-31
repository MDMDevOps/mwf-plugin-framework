<?php

namespace Mwf\Lib\Deps\Composer\Installers;

/** @internal */
class YawikInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('module' => 'module/{$name}/');
    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars) : array
    {
        $vars['name'] = \strtolower($this->pregReplace('/(?<=\\w)([A-Z])/', 'Mwf\\Lib\\Deps\\_\\1', $vars['name']));
        $vars['name'] = \str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = \str_replace(' ', '', \ucwords($vars['name']));
        return $vars;
    }
}
