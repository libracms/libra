<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace Libra\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

/**
 * Description of AbstractActionController
 * get access only if user
 *
 * @author duke
 */
class AbstractAdminActionController extends AbstractActionController
{
    public function dispatch(RequestInterface $request, ResponseInterface $response = null)
    {
        $user = $this->zfcuserauthentication()->getIdentity();
        if (!$user) {
            $this->layout()->setTemplate('layout/admin-default/login-layout');
            return $this->redirect()->toRoute('zfcuser/login');
            return $this->redirect()->toRoute('admin/libra-app/login');
        }

        return parent::dispatch($request, $response);
    }

}
