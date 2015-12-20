<?php

namespace CivAccess\Acl;

interface ResourceInterface
{   
    public function getResourceId();
    public function getResource();
    public function getDisplayName();
    public function setResourceId($resourceId);
    public function setResource($resource);
    public function setDisplayName($displayName);
}