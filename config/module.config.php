<?php

return array(
    
    // Module configuration options.
    'CivAccess' => array(
        'new_role_event_id'     => 'ZfcUser\Service\User',
        'new_role_event'        => 'register.post',
        'new_role_event_param'  => 'user',
        'old_role_event_id'     => '',
        'old_role_event'        => 'delete.post',
        'old_role_event_param'  => 'id',
        'display_info'          => false
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
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'priority' => '500',
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
            'CivAccess\Controller\Index'     => 'CivAccess\Controller\IndexController',
            'CivAccess\Controller\Rule'      => 'CivAccess\Controller\RuleController',
            'CivAccess\Controller\Role'      => 'CivAccess\Controller\RoleController',
            'CivAccess\Controller\Resource'  => 'CivAccess\Controller\ResourceController',
            'CivAccess\Controller\Privilege' => 'CivAccess\Controller\PrivilegeController',
        ),    
    ),
    
    // Service manger configuration.
    'service_manager' => array(
        'aliases' => array(
            'CivAccess\DbAdapter'   => 'Zend\Db\Adapter\Adapter',
            'CivAccess\AuthService' => 'zfcuser_auth_service'
        ),
        'invokables' => array(
            'CivAccess\Rule'        => 'CivAccess\Acl\Rule',
            'CivAccess\Role'        => 'CivAccess\Acl\Role',
            'CivAccess\Resource'    => 'CivAccess\Acl\Resource',
            'CivAccess\Privilege'   => 'CivAccess\Acl\Privilege',
        ),
        'factories' => array(
            'CivAccess\Guards'          => 'CivAccess\Guard\GuardsFactory',
            'CivAccess\DeniedStrategy'  => 'CivAccess\Strategy\DeniedStrategyFactory',
            'CivAccess\AclService'      => 'CivAccess\Service\AclServiceFactory',
            'CivAccess\RuleMapper'      => 'CivAccess\Mapper\RuleMapperFactory',
            'CivAccess\RoleMapper'      => 'CivAccess\Mapper\RoleMapperFactory',
            'CivAccess\ResourceMapper'  => 'CivAccess\Mapper\ResourceMapperFactory',
            'CivAccess\PrivilegeMapper' => 'CivAccess\Mapper\PrivilegeMapperFactory',
            'CivAccess\RuleForm'        => 'CivAccess\Form\RuleFormFactory',
            'CivAccess\RoleForm'        => 'CivAccess\Form\RoleFormFactory',
            'CivAccess\ResourceForm'    => 'CivAccess\Form\ResourceFormFactory',
            'CivAccess\PrivilegeForm'   => 'CivAccess\Form\PrivilegeFormFactory',
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