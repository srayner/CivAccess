<?php

namespace CivAccess\Acl;

interface RuleInterface
{
    public function getRole();
    public function setRole($role);
    public function getResource();
    public function setResource($resource);
    public function getPrivilege();
    public function setPrivilege($privilege);
}
