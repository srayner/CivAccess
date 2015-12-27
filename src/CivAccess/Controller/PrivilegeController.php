<?php

namespace CivAccess\Controller;

class PrivilegeController extends AbstractAclController
{
    public function indexAction()
    {
        // Ensure we have an id, if not redirect to resource list
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'resource'));
        }
        
        return array(
            'resource' => $this->getAclService()->getResourceById($id),
            'privileges' => $this->getAclService()->getPrivileges($id)
        );
    }
    
    public function addAction()
    {
        // Create a new form instance.
        $form = $this->serviceLocator->get('CivAccess\PrivilegeForm');
       
        // Check if this is a POST request.
        $request = $this->getRequest();
        if ($request->isPost())
        {
            // Bind the form to the privilege entity, and set the data from post.
            $privilege = $this->serviceLocator->get('CivAccess\Privilege');
            $form->bind($privilege);
            $form->setData($request->getPost());
            
            // Check if data is valid.
            if ($form->isValid()) {
                
                // Save new privilege to database.
                $this->getAclService()->persistPrivilege($privilege);
                
                // Redirect to privileges index page.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'privilege'));
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
                 'controller' => 'privilege',
                 'action' => 'add'
             ));
        }
        
        // Grab the privilege with the specified id.
        $privilege = $this->getAclService()->getPrivilegeById($id);
        $form = $this->getServiceLocator()->get('CivAccess\PrivilegeForm');
        $form->bind($privilege);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                // Persist privilege.
                $this->getAclService()->persistPrivilege($privilege);
                
                // Redirect to list of privileges.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'privilege'));
            }     
        }
        
        return array(
             'privilegeId' => $id,
             'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        // Ensure we have an id, if not redirect to resource list
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'privilege'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            // Only perform delete if value posted was 'Yes'.
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAclService()->deletePrivilegeById($id);
            }

            // Redirect to list of privileges.
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'privilege'));
         }
        
        // If not a POST request, then render the confirmation page.
        return array(
            'privilege' => $this->getAclService()->getPrivilegeById($id)    
        );
    }
}