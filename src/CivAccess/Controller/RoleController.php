<?php

namespace CivAccess\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    protected $aclService;
    
    protected function getAclService()
    {
        if (null === $this->aclService){
            $this->aclService = $this->getServiceLocator()->get('CivAccess\AclService');
        }
        return $this->aclService;
    }
    
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
        // Create a new form instance.
        $form = $this->serviceLocator->get('CivAccess\RoleForm');
       
        // Check if this is a POST request.
        $request = $this->getRequest();
        if ($request->isPost())
        {
            // Bind the form to the role entity, and set the data from post.
            $role = $this->serviceLocator->get('CivAccess\Role');
            $form->bind($role);
            $form->setData($request->getPost());
            
            // Check if data is valid.
            if ($form->isValid()) {
                
                // Save new rule to database.
                $role->setRoleType('Group role.');
                $aclService = $this->getAclService();
                $aclService->persistRole($role);
                
                // Redirect to roles index page.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'role'));
            }
        }
        
        // If not post, or invalid data, render the form.
        return array(
            'form' => $form
        );
    }
    
    public function editAction()
    {
        // Ensure we have an id, else redirect to add action.
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('civaccess/default', array(
                 'controller' => 'role',
                 'action' => 'add'
             ));
        }
        
        // Grab the role with the specified id.
        $role = $this->getAclService()->getRoleById($id);
        $form = $this->getServiceLocator()->get('CivAccess\RoleForm');
        $form->bind($role);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                // Persist role.
                $this->getAclService()->persistRole($role);
                
                // Redirect to list of jobs
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'role'));
            }     
        }
        
        return array(
             'roleId' => $id,
             'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        return array();
    }
}