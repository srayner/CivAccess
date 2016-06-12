<?php

namespace CivAccess\Strategy;

use Zend\Mvc\Application;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use CivAccess\Guard\Guard;
use CivAccess\Exception\UnAuthorizedException;

class DeniedStrategy implements ListenerAggregateInterface
{
    protected $template;
    protected $displayInfo;
    protected $listeners = array();
    
    public function __construct($template, $displayInfo)
    {
        $this->template = (string) $template;
        $this->displayInfo = $displayInfo;
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
           'error'        => $event->getParam('error'),
           'identity'     => $event->getParam('identity'),
           'display_info' => $this->displayInfo
        );
        switch ($event->getError()) {
            case Guard::ERROR:
                $viewVariables['role'] = $event->getParam('role');
                $viewVariables['resource'] = $event->getParam('resource');
                $viewVariables['privilege']     = $event->getParam('privilege');
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
        
        $response = $response ?: new Response();
        if ($viewVariables['role'] == 'guest') {
            $container = new Container('redirect');
            $container->url = $event->getRequest()->getUri()->getPath();
            $response->getHeaders()->addHeaderLine('Location', '/login');
            $response->setStatusCode(302);
        } else {
            $model = new ViewModel($viewVariables);
            $model->setTemplate($this->getTemplate());
            $event->getViewModel()->addChild($model);
            $response->setStatusCode(403);
        }
        $event->setResponse($response);
    }

}
