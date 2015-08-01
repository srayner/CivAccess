<?php

namespace CivAccess\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel;
    }
}