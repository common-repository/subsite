<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1e41482c02e1711363eecdd9a33e3d54
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPSubsite\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPSubsite\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1e41482c02e1711363eecdd9a33e3d54::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1e41482c02e1711363eecdd9a33e3d54::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1e41482c02e1711363eecdd9a33e3d54::$classMap;

        }, null, ClassLoader::class);
    }
}
