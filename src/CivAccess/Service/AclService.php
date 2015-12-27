<?php

namespace CivAccess\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use CivAccess\Acl\Role;

class AclService
{
    protected $acl;
    protected $privilegeMapper;
    protected $resourceMapper;
    protected $roleMapper;
    protected $ruleMapper;
    
    public function __construct($privilegeMapper, $resourceMapper, $roleMapper, $ruleMapper)
    {
        $this->privilegeMapper = $privilegeMapper;
        $this->resourceMapper = $resourceMapper;
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
        $this->roleMapper->persist($roleEntity);
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
    
    public function getRoles()
    {
        // Exclude user roles.
        $where = "role_type <> 'User role.'";
        return $this->roleMapper->getRoles($where);
    }
    
    public function getRoleById($roleId)
    {
        return $this->roleMapper->getRoleById($roleId);
    }
    
    public function persistRole($role)
    {
        return $this->roleMapper->persist($role);
    }
    
    public function deleteRoleById($roleId)
    {
        return $this->roleMapper->deleteRoleById($roleId);
    }
    
    public function getPrivileges($resourceId)
    {
        return $this->privilegeMapper->getPrivileges($resourceId);
    }
    
    public function getPrivilegeById($id)
    {
        return $this->privilegeMapper->getPrivilegeById($id);
    }
    
    public function persistPrivilege($privilege)
    {
        return $this->privilegeMapper->persist($privilege);
    }
    
    public function deletePrivilegeById($id)
    {
        return $this->privilegeMapper->deletePrivilegeById($id);
    }
    
    public function getResources()
    {
        return $this->resourceMapper->getResources();
    }
    
    public function getResourceById($id)
    {
        return $this->resourceMapper->getResourceById($id);
    }
    
    public function persistResource($resource)
    {
        return $this->resourceMapper->persist($resource);
    }
    
    public function deleteResourceById($id)
    {
        return $this->resourceMapper->deleteResourceById($id);
    }
}

