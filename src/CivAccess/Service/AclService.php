<?php

namespace CivAccess\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

class AclService
{
    protected $acl;
    protected $roleMapper;
    protected $ruleMapper;
    
    public function __construct($roleMapper, $ruleMapper)
    {
        $this->roleMapper = $roleMapper;
        $this->ruleMapper = $ruleMapper;
        $this->acl = new Acl();
        $this->loadRoles();
    }
   
    /**
     * Checks the access control list to see if the role is allowed the required priviledge to the resource.
     * @param type $role
     * @param type $resource
     * 
     * @return boolean - true if the role is allowed access, false otherwise
     */
    public function IsAllowed($role, $resource, $priviledge)
    {
        $this->acl->addResource(New GenericResource($resource));
        $this->loadRelevantRules($role);
        return $this->acl->isAllowed($role, $resource, $priviledge);
    }
    
    public function addRole($role, $parent)
    {
        $roleEntity = new \CivAccess\Role\Role();
        $roleEntity->setRole($role)
                   ->setParent($parent)
                   ->setPriority(4);
        $this->roleMapper->persist($roleEntity);
    }
    
    protected function loadRelevantRules($role)
    {     
        $rules = $this->ruleMapper->getRules();
        
        foreach($rules as $rule){
            if (!$this->acl->hasResource($rule->getResource())){
                $this->acl->addResource($rule->getResource());
            }
            $this->acl->allow($rule->getRole(), $rule->getResource(), $rule->getPriviledge());
        } 
    }
    
    private function loadRoles()
    {  
        $previousRole = '';
        $parents = array();
        
        $roles = $this->roleMapper->getRoles();
        foreach($roles as $current)
        {
            $currentRole   = $current->getRole();
            $currentParent = $current->getParent();
                   
            if (($currentRole != $previousRole) && ($previousRole != '')){
                            
                // Push the previous role onto the acl.
                if (empty($parents)){
                    $parents = null;
                }
                $this->acl->addRole(new GenericRole($previousRole), $parents);
                $parents = array();
                
            }
            
            if (null != $currentParent){
                array_push($parents, $currentParent);
            }
            
            $previousRole = $currentRole;
        }
        
        if ($previousRole != ''){
                
            // Push the previous role onto the acl.
            if (empty($parents)){
                $parents = null;
            }
            $this->acl->addRole(new GenericRole($previousRole), $parents);
            $parents = array();
        }
    }  
}

