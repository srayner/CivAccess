<?php

namespace CivAccess\Mapper;

interface RoleMapperInterface
{
    public function getRoles($where = null);
    public function getRoleById($roleId);
    public function persist($role);
    public function deleteRoleById($roleId);
    public function deleteRoleByRole($role);
}

