<?php

namespace CivAccess\Controller;

use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractAclController extends AbstractActionController
{
    protected $aclService;
    
    protected function getAclService()
    {
        if (null === $this->aclService){
            $this->aclService = $this->getServiceLocator()->get('CivAccess\AclService');
        }
        return $this->aclService;
    }
}