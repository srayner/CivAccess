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
        $config         = $serviceManager->get('config')['CivAccess'];
        
        // Attach the guards as listeners.
        foreach ($guards as $guard) {
            $eventManager->attach($guard);
        }
            
        // Attach a strategy to take if access is denied.
        $eventManager->attach($strategy);
        
        // listen for new roles (if configured)
        if ($config['new_role_event_id'] != '') { 
            $param = $config['new_role_event_param'];
            $sharedEventManager = $eventManager->getSharedManager();
            $sharedEventManager->attach($config['new_role_event_id'], $config['new_role_event'], function($e) use($serviceManager, $param) {
                $role = $e->getParam($param)->getId();
                $service = $serviceManager->get('CivAccess\AclService');
                $service->addRole($role, 'user');
            }, 100);
        }
        
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
        return include __DIR__ . '/config/module.config.php';
    }
   
}