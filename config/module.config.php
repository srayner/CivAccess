<?php

return array(
    
    // Module configuration options.
    'CivAccess' => array(
        'new_role_event_id'     => 'ZfcUser\Service\User',
        'new_role_event'        => 'register.post',
        'new_role_event_param'  => 'user'
    ),
    
    // Router configuration.
    'router' => array(
        'routes' => array(
            'civaccess' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/access',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CivAccess\Controller',
                        'controller'    => 'Rule',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'CivAccess\Controller\Rule' => 'CivAccess\Controller\RuleController',
            'CivAccess\Controller\Role'  => 'CivAccess\Controller\RoleController',
        ),    
    ),
    
    // Service manger configuration.
    'service_manager' => array(
        'aliases' => array(
            'CivAccess\DbAdapter'   => 'Zend\Db\Adapter\Adapter',
            'CivAccess\AuthService' => 'zfcuser_auth_service'
        ),
        'invokables' => array(
            'CivAccess\Rule' => 'CivAccess\Acl\Rule',    
        ),
        'factories' => array(
            'CivAccess\Guards'         => 'CivAccess\Guard\GuardsFactory',
            'CivAccess\DeniedStrategy' => 'CivAccess\Strategy\DeniedStrategyFactory',
            'CivAccess\AclService'     => 'CivAccess\Service\AclServiceFactory',
            'CivAccess\RuleMapper'     => 'CivAccess\Mapper\RuleMapperFactory',
            'CivAccess\RoleMapper'     => 'CivAccess\Mapper\RoleMapperFactory',
            'CivAccess\RuleForm'       => 'CivAccess\Form\RuleFormFactory'
        ),    
    ),
    
    // View manager configuration.
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
);