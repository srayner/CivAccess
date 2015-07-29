<?php

namespace CivAccess;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app            = $e->getApplication();
        $eventManager   = $app->getEventManager();
        $serviceManager = $app->getServiceManager();
        $guards         = $serviceManager->get('CivAccess\Guards');
        $strategy       = $serviceManager->get('CivAccess\DeniedStrategy');
        
        // Attach the guards as listeners.
        foreach ($guards as $guard) {
            $eventManager->attach($guard);
        }
        
        // Attach a strategy to take if access is denied.
        $eventManager->attach($strategy);
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . './config/module.config.php';
    }
}
