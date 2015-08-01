<?php

namespace CivAccess\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RuleController extends AbstractActionController
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
        $rules = $aclService->getRules();
        return array(
            'rules' => $rules
        );
    }
    
    public function addAction()
    {
        // Create a new form instance.
        $form = $this->serviceLocator->get('CivAccess\RuleForm');
       
        // Check if this is a POST request.
        $request = $this->getRequest();
        if ($request->isPost())
        {
            // Bind the form to the rule entity, and set the data from post.
            $rule = $this->serviceLocator->get('CivAccess\Rule');
            $form->bind($rule);
            $form->setData($request->getPost());
            
            // Check if data is valid.
            if ($form->isValid()) {
                
                // Save new rule to database.
                $aclService = $this->getAclService();
                $aclService->persistRule($rule);
                
                // Redirect to rules index page.
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'rule'));
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
                 'controller' => 'rule',
                 'action' => 'add'
             ));
        }
        
        // Grab the rule with the specified id.
        $rule = $this->getAclService()->getRuleById($id);
        $form = $this->getServiceLocator()->get('CivAccess\RuleForm');
        $form->bind($rule);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                // Persist rule.
                $this->getAclService()->persistRule($rule);
                
                // Redirect to list of jobs
                return $this->redirect()->toRoute('civaccess/default', array('controller' => 'rule'));
            }     
        }
        
        return array(
             'ruleId' => $id,
             'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        // Ensure we have a rule id, if not redirect to rule list
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'rule'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            // Only perform delete if value posted was 'Yes'.
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAclService()->deleteRuleById($id);
            }

            // Redirect to list of jobs
            return $this->redirect()->toRoute('civaccess/default', array('controller' => 'rule'));
         }
        
        // If not a POST request, then render the confirmation page.
        return array(
            'rule' => $this->getAclService()->getRuleById($id)    
        );
    }
}