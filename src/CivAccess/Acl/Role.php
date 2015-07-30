<?php

namespace CivAccess\Acl;

class Role implements RoleInterface
{
    protected $role;
    protected $parent;
    protected $priority;
    
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
    
    public function getPriority()
    {
        return $this->priority;
    }
    
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
}