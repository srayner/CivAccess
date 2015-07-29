<?php

namespace CivAccess\Mapper;

use Zend\Db\Adapter\Adapter;

interface DbAdapterAwareInterface
{
    public function setDbAdapter(Adapter $dbAdapter);
}

