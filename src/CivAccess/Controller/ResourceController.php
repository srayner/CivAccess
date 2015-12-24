<?php

namespace CivAccess\Controller;

class ResourceController extends AbstractAclController
{
    public function indexAction()
    {
        return array(
            'resources' => $this->getAclService()->getResources()
        );
    }
    
    public function addAction()
    {
        // Create a new form instance.
        $form = $this->serviceLocator->get('CivAccess\ResourceForm');
       
        // Check if this is a POST request.
        $request = $this->getRequest();
        if ($request->isPost())
        {
            // Bind the form to the resource entity, and set the data from post.
            $resource = $this->serviceLocator->get('CivAccess\Resource');
            $form->bind($resource);
            $form->setData($request->getPost());
            
            // Check if data is valid.
            if ($form->isValid()) {
                
                // Save new resource to database.
                $this->getAclService()->persistResource($resource);
                
                // Redirect to resources index page.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'resource'));
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
                 'controller' => 'resource',
                 'action' => 'add'
             ));
        }
        
        // Grab the resource with the specified id.
        $resource = $this->getAclService()->getResourceById($id);
        $form = $this->getServiceLocator()->get('CivAccess\ResourceForm');
        $form->bind($resource);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                // Persist resource.
                $this->getAclService()->persistResource($resource);
                
                // Redirect to list of resources.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'resource'));
            }     
        }
        
        return array(
             'resourceId' => $id,
             'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        // Ensure we have an id, if not redirect to resource list
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'resource'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            // Only perform delete if value posted was 'Yes'.
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAclService()->deleteResourceById($id);
            }

            // Redirect to list of resources.
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'resource'));
         }
        
        // If not a POST request, then render the confirmation page.
        return array(
            'resource' => $this->getAclService()->getResourceById($id)    
        );
    }
}