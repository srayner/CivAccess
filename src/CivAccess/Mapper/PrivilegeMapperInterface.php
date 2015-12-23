<?php

namespace CivAccess\Mapper;

interface PrivilegeMapperInterface
{
    public function getPrivileges();
    public function getPrivilegeById($id);
    public function deletePrivilegeById($id);
    public function persist($privilege);
}

