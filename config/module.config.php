<?php

return array(
    
    'service_manager' => array(
        'factories' => array(
            'CivAccess\Guards'            => 'CivAccess\Guard\GuardsFactory',
            'CivAccess\ForbiddenStrategy' => 'CivAccess\Strategy\DeniedStrategyFactory',
            'CivAccess\AuthService'       => 'CivAccess\Service\AuthServiceFactory'
        ),    
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ),
    ),
    
);