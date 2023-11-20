<?php

function customize_php_scoper_config( array $config ): array
{
    $wpify = include dirname(__DIR__, 1) . '/vendor/wpify/scoper/symbols/wordpress.php';

    $config[ 'exclude-functions' ] = $wpify[ 'expose-functions' ];

    return $config;
}