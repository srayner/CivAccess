<?php

namespace CivAccess\Mapper;

interface ResourceMapperInterface
{
    public function getResources();
    public function getResourceById($id);
    public function deleteResourceById($id);
    public function persist($resource);
}
