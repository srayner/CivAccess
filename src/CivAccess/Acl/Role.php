<?php

namespace CivAccess\Acl;

class Role implements RoleInterface
{
    protected $role;
    protected $parent;
    
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
}