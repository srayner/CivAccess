<?php

namespace CivAccess\Mapper;

interface RuleMapperInterface
{
    public function getRules();
    public function getRuleById($ruleId);
    public function getRulesForRole($role);
    public function deleteRuleById($ruleId);
    public function persist($rule);
}
