<?php

return array(
    
    'service_manager' => array(
        'aliases' => array(
            'CivAccess\DbAdapter'   => 'Zend\Db\Adapter\Adapter',
            'CivAccess\AuthService' => 'zfcuser_auth_service'
        ),
        'factories' => array(
            'CivAccess\Guards'         => 'CivAccess\Guard\GuardsFactory',
            'CivAccess\DeniedStrategy' => 'CivAccess\Strategy\DeniedStrategyFactory',
            'CivAccess\AclService'     => 'CivAccess\Service\AclServiceFactory',
            'CivAccess\RuleMapper'     => 'CivAccess\Mapper\RuleMapperFactory',
            'CivAccess\RoleMapper'     => 'CivAccess\Mapper\RoleMapperFactory',
        ),    
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ),
    ),
    
);