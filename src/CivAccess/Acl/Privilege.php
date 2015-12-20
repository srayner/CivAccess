<?php

namespace CivAccess\Acl;

class Privilege implements PrivilegeInterface
{
    protected $privilegeId;
    protected $resourceId;
    protected $privilege;
    protected $displayName;
    
    public function getPrivilegeId()
    {
        return $this->privilegeId;
    }

    public function getResourceId()
    {
        return $this->resourceId;
    }

    public function getPrivilege()
    {
        return $this->privilege;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setPrivilegeId($privilegeId)
    {
        $this->privilegeId = $privilegeId;
        return $this;
    }

    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
        return $this;
    }

    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }
}
