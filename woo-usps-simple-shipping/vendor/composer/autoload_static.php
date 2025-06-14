<?php

// autoload_static.php @generated by Composer

namespace Dgm\UspsSimple\Vendors\Composer\Autoload;

class ComposerStaticInit59e456511c0990b49636001ee00b9848
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dgm\\UspsSimple\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dgm\\UspsSimple\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Dgm\\UspsSimple\\Vendors\\Dgm\\WcTools\\WcTools' => __DIR__ . '/..' . '/dangoodman/wc-tools/WcTools.php',
        'Dgm_UspsSimple_Vendors_DgmWpDismissibleNotices' => __DIR__ . '/..' . '/dangoodman/wp-plugin-bootstrap-guard/DgmWpDismissibleNotices.php',
        'Dgm_UspsSimple_Vendors_DgmWpPluginBootstrapGuard' => __DIR__ . '/..' . '/dangoodman/wp-plugin-bootstrap-guard/DgmWpPluginBootstrapGuard.php',
    );

    public static function getInitializer(\Dgm\UspsSimple\Vendors\Composer\Autoload\ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = \Dgm\UspsSimple\Vendors\Composer\Autoload\ComposerStaticInit59e456511c0990b49636001ee00b9848::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = \Dgm\UspsSimple\Vendors\Composer\Autoload\ComposerStaticInit59e456511c0990b49636001ee00b9848::$prefixDirsPsr4;
            $loader->classMap = \Dgm\UspsSimple\Vendors\Composer\Autoload\ComposerStaticInit59e456511c0990b49636001ee00b9848::$classMap;

        }, null, \Dgm\UspsSimple\Vendors\Composer\Autoload\ClassLoader::class);
    }
}
