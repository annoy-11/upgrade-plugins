<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f514005cddd3ec4281d42cc68883807
{
    public static $prefixesPsr0 = array (
        'L' => 
        array (
            'Less' => 
            array (
                0 => __DIR__ . '/..' . '/oyejorge/less.php/lib',
            ),
        ),
    );

    public static $classMap = array (
        'lessc' => __DIR__ . '/..' . '/oyejorge/less.php/lessc.inc.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit1f514005cddd3ec4281d42cc68883807::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1f514005cddd3ec4281d42cc68883807::$classMap;

        }, null, ClassLoader::class);
    }
}
