<?php

namespace CivAccess\Acl;

interface PrivilegeInterface
{
    public function getPrivilegeId();
    public function getResourceId();
    public function getPrivilege();
    public function getDisplayName();
    public function setPrivilegeId($privilegeId);
    public function setResourceId($resourceId);
    public function setPrivilege($privilge);
    public function setDisplayName($displayName);
}