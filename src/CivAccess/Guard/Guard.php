<?php

namespace CivAccess\Guard;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\ServiceManager\ServiceLocatorInterface;

use CivAccess\Exception\UnAuthorizedException;

class Guard extends AbstractListenerAggregate
{
    const ERROR = 'unauthorized';
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onDispatch'), -1000);
    }
    
    public function onDispatch(MvcEvent $event)
    {
        $app         = $event->getTarget();
        $aclService  = $this->serviceLocator->get('CivAccess\AclService');
        $authService = $this->serviceLocator->get('CivAccess\AuthService');
        $match      = $event->getRouteMatch();
        $resource   = $match->getParam('controller');
        $priviledge = $match->getParam('action');
        
        // Check access.
        $role   = $authService->hasIdentity() ? (string)$authService->getIdentity()->getId() : 'guest';
        $authorized = $aclService->isAllowed($role, $resource, $priviledge);
        
        // If authorized, no action is required.
        if ($authorized) {
            return;
        }
        
        // If not authorized, setup an exception and trigger a dispatch error.
        $errorMessage = sprintf("You are not authorized to access %s:%s", $resource, $priviledge);
        $event->setError(static::ERROR);
        $event->setParam('role', $role);
        $event->setParam('resource', $resource);
        $event->setParam('priviledge', $priviledge);
        $event->setParam('exception', new UnAuthorizedException($errorMessage));
        $app->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }
}