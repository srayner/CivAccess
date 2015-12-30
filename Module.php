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
        
        // Register a "render" event, at high priority (so it executes prior
        // to the view attempting to render)
        $eventManager->attach('render', array($this, 'registerJsonStrategy'), 100);
        
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
        
        // listen for deleted roles (if configured)
        if ($config['old_role_event_id'] != '') { 
            $param = $config['old_role_event_param'];
            $sharedEventManager = $eventManager->getSharedManager();
            $sharedEventManager->attach($config['old_role_event_id'], $config['old_role_event'], function($e) use($serviceManager, $param) {
                $role = $e->getParam($param);
                $service = $serviceManager->get('CivAccess\AclService');
                $service->deleteRole($role);
            }, 100);
        }
        
    }
    
    /**
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy($e)
    {
        $app          = $e->getTarget();
        $locator      = $app->getServiceManager();
        $view         = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        // Attach strategy, which is a listener aggregate, at high priority
        $view->getEventManager()->attach($jsonStrategy, 100);
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