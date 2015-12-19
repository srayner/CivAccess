<?php

namespace CivAccess\Acl;

interface RoleInterface
{
    public function getRole();
    public function setRole($role);
    public function getParent();
    public function setParent($parent);
    public function getRoleType();
    public function setRoleType($roleType);
}
