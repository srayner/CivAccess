<?php

namespace CivAccess\Acl;

class Resource implements ResourceInterface
{
    protected $resourceId;
    protected $resource;
    protected $displayName;
    
    public function getResourceId()
    {
        return $this->resourceId;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
        return $this;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }
}