<?php

namespace CivAccess\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    public function indexAction()
    {
        $aclService = $this->getServiceLocator()->get('CivAccess\AclService');
        $roles = $aclService->getRoles();
        return array(
            'roles' => $roles
        );
    }
    
    public function addAction()
    {
        return array();
    }
    
    public function deleteAction()
    {
        return array();
    }
}