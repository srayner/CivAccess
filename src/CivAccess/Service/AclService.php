<?php

namespace CivAccess\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

class AclService
{
    protected $acl;
    protected $dbMapper;
    
    public function __construct($dbMapper)
    {
        $this->dbMapper = $dmMapper;
        $this->acl = new Acl();
    }
   
    /**
     * Checks the access control list to see if the role is allowed the required priviledge to the resource.
     * @param type $role
     * @param type $resource
     * 
     * @return boolean - true if the role is allowed access, false otherwise
     */
    public function IsAllowed($role, $resource, $priviledge)
    {
        $this->acl->addRole(New GenericRole($role));
        $this->acl->addResource(New GenericResource($resource));
        $this->loadRelevantRules($role);
        return $this->acl->isAllowed($role, $resource, $priviledge);
    }
    
    protected function loadRelevantRules($role)
    {
        $rules = array(
            array('guest', 'Application\Controller\Index', 'index'),
            array('guest', 'Application\Controller\Mock', 'index'),
            array('guest', 'Application\Controller\Mock', 'add'),
        );
        
        //$rules = $this->dbMapper->getRulesFor($role);
        
        foreach($rules as $rule){
            if (!$this->acl->hasResource($rule[1])){
                $this->acl->addResource($rule[1]);
            }
            $this->acl->allow($rule[0], $rule[1], $rule[2]);
        } 
    }
}

