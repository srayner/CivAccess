<?php

namespace CivAccess\Acl;

class Role implements RoleInterface
{
    protected $role;
    protected $parent;
    protected $roleType;
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
    
    public function getRoleType()
    {
        return $this->roleType;
    }
    
    public function setRoleType($roleType)
    {
        $this->roleType = $roleType;
        return $this;
    }
}