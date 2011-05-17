<?php


namespace SilexExtension;

use Silex\Application;
use Silex\ExtensionInterface;

use Predis\Client, 
    Predis\ClientOptions,
    Predis\DispatcherLoop,
    Predis\ConnectionParameters;

class PredisExtension implements ExtensionInterface
{
    public function register(Application $app)
    {  
        $app['predis'] = $app->share(function () use ($app) {
            $server = isset($app['predis.server']) ? $app['predis.server'] : array();
            $config = isset($app['predis.config']) ? $app['predis.config'] : array();
        
            return new Client(new ConnectionParameters($server), new ClientOptions($config));
        });
        
        
        // autoloading the doctrine mongodb library
        if (isset($app['predis.class_path'])) {
            $app['autoloader']->registerNamespace('Predis', $app['predis.class_path']);
        }
    }
}
