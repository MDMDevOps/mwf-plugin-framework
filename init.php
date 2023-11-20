<?php

namespace Mwf\Lib;

require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'deps/autoload.php';

function init( Main $main ) : void
{
    $main->load();
}