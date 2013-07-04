<?php
/**
 * User: duke.
 * Date: 7/4/13
 * Time: 2:32 PM
 */

namespace Libra\Mvc\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController as ZFAbstractActionController;
use Zend\Mvc\Exception\RuntimeException;

class AbstractActionController extends ZFAbstractActionController
{
    protected $entityName;

    /** @var EntityManager */
    protected $entityManager;

    /** @var EntityRepository */
    protected $repository;

    public function getEntityManager()
    {
        if ($this->entityManager === null) {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    public function getRepository()
    {
        if ($this->entityName === null) {
            throw new RuntimeException('No $entityName specified');
        }
        if ($this->repository === null) {
            $this->repository = $this->getEntityManager()->getRepository($this->entityName);
        }

        return $this->repository;
    }

    public function getEntityName()
    {
        return $this->entityName;
    }

    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
        $this->repository = null;

        return $this;
    }

}