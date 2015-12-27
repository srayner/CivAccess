<?php

namespace CivAccess\Mapper;

interface PrivilegeMapperInterface
{
    public function getPrivileges($resourceId);
    public function getPrivilegeById($id);
    public function deletePrivilegeById($id);
    public function persist($privilege);
}

