<?php

namespace CivAccess\Strategy;

use Zend\Mvc\Application;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;

use CivAccess\Guard\Guard;
use CivAccess\Exception\UnAuthorizedException;

class DeniedStrategy implements ListenerAggregateInterface
{
    protected $template;
    protected $listeners = array();
    
    public function __construct($template)
    {
        $this->template = (string) $template;
    }
    
    public function attach(\Zend\EventManager\EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -5000); 
    }

    public function detach(\Zend\EventManager\EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener)
        {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }
    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function onDispatchError(MvcEvent $event)
    {
        $result   = $event->getResult();
        $response = $event->getResponse();
        
        // Do nothing if the result is a response object
        if ($result instanceof ResponseInterface || ($response && ! $response instanceof Response)) {
            return;
        }
        
        // Common view variables
        $viewVariables = array(
           'error'      => $event->getParam('error'),
           'identity'   => $event->getParam('identity'),
        );
        switch ($event->getError()) {
            case Guard::ERROR:
                $viewVariables['controller'] = $event->getParam('controller');
                $viewVariables['action']     = $event->getParam('action');
                break;
            case Application::ERROR_EXCEPTION:
                if (!($event->getParam('exception') instanceof UnAuthorizedException)) {
                    return;
                }
                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                $viewVariables['error']  = 'error-unauthorized';
                break;
            default:
                /*
                 * do nothing if there is no error in the event or the error
                 * does not match one of our predefined errors (we don't want
                 * our 403 template to handle other types of errors)
                 */
                return;
        }
        
        $model    = new ViewModel($viewVariables);
        $response = $response ?: new Response();
        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(403);
        $event->setResponse($response);
    }

}
