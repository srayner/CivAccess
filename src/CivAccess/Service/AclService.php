<?php

namespace CivAccess\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use CivAccess\Acl\Role;

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
     * Checks the access control list to see if the role is allowed the required privilege to the resource.
     * @param type $role
     * @param type $resource
     * 
     * @return boolean - true if the role is allowed access, false otherwise
     */
    public function IsAllowed($role, $resource, $privilege)
    {
        $this->acl->addResource(New GenericResource($resource));
        $this->loadRelevantRules($role);
        return $this->acl->isAllowed($role, $resource, $privilege);
    }
    
    public function addRole($role, $parent)
    {
        $roleEntity = new Role();
        $roleEntity->setRole($role)
                   ->setParent($parent)
                   ->setRoleType('User role.');
        $this->roleMapper->persistRole($roleEntity);
    }
    
    protected function loadRelevantRules($role)
    {     
        $rules = $this->ruleMapper->getRules();
        
        foreach($rules as $rule){
            if (!$this->acl->hasResource($rule->getResource())){
                $this->acl->addResource($rule->getResource());
            }
            $this->acl->allow($rule->getRole(), $rule->getResource(), $rule->getPrivilege());
        } 
    }
    
    public function loadRoles()
    {
        $map = array();
        
        $roles = $this->roleMapper->getRoles();
        foreach($roles as $role)
        {
            $roleName = $role->getRole();
            $parentName = $role->getParent();
            
            if (key_exists($roleName, $map)) {
                if (null != $parentName) {
                    array_push($map[$roleName], $parentName);
                }
            } else {
                $map[$roleName] = (null != $parentName ? array($parentName) : null);
            }
        }
        foreach($map as $role => $parents) {
            $this->loadRole($map, $role, $parents);
        }
    }
    
    private function loadRole($map, $role, $parents)
    {
        // Check parents are loaded
        if (null != $parents) {
            foreach($parents as $parent)
            {
                if (!$this->acl->hasRole($parent)) {
                    $r = $parent;
                    $p = $map[$parent];
                    $this->loadRole($map, $r, $p);
                }
            }
        }
        
        // load the role
        if (!$this->acl->hasRole($role)) {
            $genericRole = new GenericRole($role);
            $this->acl->addRole($genericRole, $parents);
        }
    }
    
    public function deleteRuleById($ruleId)
    {
        return $this->ruleMapper->deleteRuleById($ruleId);
    }

    public function getRoles()
    {
        // Exclude user roles.
        $where = "role_type <> 'User role.'";
        return $this->roleMapper->getRoles($where);
    }
    
    public function getRules()
    {
        return $this->ruleMapper->getRules();
    }
    
    public function getRuleById($ruleId)
    {
        return $this->ruleMapper->getRuleById($ruleId);
    }
    
    public function persistRule($rule)
    {
        return $this->ruleMapper->persist($rule);
    }
    
    public function persistRole($role)
    {
        return $this->roleMapper->persist($role);
    }
    
    public function deleteRole($role)
    {
        return $this->roleMapper->deleteRole($role);
    }
}

