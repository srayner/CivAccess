<?php

namespace CivAccess\Service;

use Zend\Permissions\Acl\Acl;

class AclService
{
    protected $acl;
    
    public function __construct()
    {
        $this->acl = new Acl();
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
        return $this->acl->isAllowed($role, $resource, $priviledge);
    }
}

