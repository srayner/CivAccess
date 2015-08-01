<?php

namespace CivAccess\Acl;

class Rule implements RuleInterface
{
    protected $ruleId;
    protected $role;
    protected $resource;
    protected $privilege;

    public function getRuleId()
    {
        return $this->ruleId;
    }
    
    public function setRuleId($ruleId)
    {
        $this->ruleId = $ruleId;
        return $this;
    }
    
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
    
    public function getPrivilege()
    {
        return $this->privilege;
    }
    
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }
}