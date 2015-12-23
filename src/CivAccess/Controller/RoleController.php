<?php

namespace CivAccess\Controller;

class RoleController extends AbstractAclController
{   
    public function indexAction()
    {
        return array(
            'roles' => $this->getAclService()->getRoles()
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
                $this->getAclService()->persistRole($role);
                
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
                
                // Redirect to list of roles.
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
        // Ensure we have a role id, if not redirect to role list
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'role'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            // Only perform delete if value posted was 'Yes'.
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAclService()->deleteRoleById($id);
            }

            // Redirect to list of roles.
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'role'));
         }
        
        // If not a POST request, then render the confirmation page.
        return array(
            'role' => $this->getAclService()->getRoleById($id)    
        );
    }
}