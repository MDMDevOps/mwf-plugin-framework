<?php

function customize_php_scoper_config( array $config ): array
{
    $wpify = include dirname(__DIR__, 1) . '/vendor/wpify/scoper/symbols/wordpress.php';

    $config[ 'exclude-functions' ] = $wpify[ 'expose-functions' ];
    $config[ 'exclude-constants' ] = $wpify[ 'expose-constants' ];
    $config[ 'exclude-classes' ] = $wpify[ 'expose-classes' ];
    $config[ 'exclude-namespaces' ] = $wpify[ 'expose-namespaces' ];

    $config['patchers'] = [
        static function (string $filePath, string $prefix, string $content): string {
            if (str_contains( strtolower( $filePath ), strtolower( "source/vendor/php-di/php-di/src/Container.php" ) ) ) {
                $content = str_replace( 'private', 'protected', $content );
            }
            return $content;
        },
    ];

    return $config;
}