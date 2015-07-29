<?php

return array(
    
    'service_manager' => array(
        'factories' => array(
            'CivAccess\Guards'         => 'CivAccess\Guard\GuardsFactory',
            'CivAccess\DeniedStrategy' => 'CivAccess\Strategy\DeniedStrategyFactory',
            'CivAccess\AclService'     => 'CivAccess\Service\AclServiceFactory'
        ),    
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ),
    ),
    
);