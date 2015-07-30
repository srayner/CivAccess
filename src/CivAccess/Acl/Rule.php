<?php

namespace CivAccess\Acl;

class Rule implements RuleInterface
{
    protected $role;
    protected $resource;
    protected $priviledge;
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    public function getPriviledge()
    {
        return $this->priviledge;
    }
    
    public function setPriviledge($priviledge)
    {
        $this->priviledge = $priviledge;
        return $this;
    }
}