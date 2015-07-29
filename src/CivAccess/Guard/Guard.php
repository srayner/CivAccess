<?php

namespace CivAccess\Guard;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\AbstractListenerAggregate;

use CivAccess\Exception\UnAuthorizedException;

class Guard extends AbstractListenerAggregate
{
    const ERROR = 'unauthorized';
    
    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onDispatch'), -1000);
    }
    
    public function onDispatch(MvcEvent $event)
    {
        $app        = $event->getTarget();
        $service    = $this->serviceLocator->get('CivAccess\AuthService');
        $match      = $event->getRouteMatch();
        $role       = $service->getRole();
        $resource   = $match->getParam('controller');
        $priviledge = $match->getParam('action');
        
        // Check access.
        $authorized = $this->authService->isAllowed($role, $resource, $priviledge);
        
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