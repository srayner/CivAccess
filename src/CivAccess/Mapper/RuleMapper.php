<?php

namespace CivAccess\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

class RuleMapper extends AbstractDbMapper implements RuleMapperInterface
{
    protected $tableName = 'access_rule';
    
    public function getRules()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }
    
    public function getRuleById($ruleId)
    {
        $select = $this->getSelect()
                       ->where(array('rule_id' => $ruleId));
        return $this->select($select)->current();
    }
    
    public function getRulesForRole($role)
    {
        $select = $this->getSelect()
                       ->where(array('role' => $role));
        return $this->select($select);
    }
    
    public function deleteRuleById($ruleId)
    {
        return parent::delete(array('rule_id' => $ruleId));
    }
    
    public function persist($rule)
    {
        if ($rule->getRuleId() > 0) {
            $this->update($rule, null, null, new ClassMethods());
        } else {
            $this->insert($rule, null, new ClassMethods());
        }
        return $rule; 
    }
    
    protected function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setRuleId($result->getGeneratedValue());
        return $result;
    }
    
    protected function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'rule_id = ' . $entity->getRuleId();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }
}