<?php
/**
 * User: duke.
 * Date: 7/4/13
 * Time: 2:32 PM
 */

namespace Libra\Mvc\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractEntityManagerProvider implements ServiceLocatorAwareInterface
{
    /** @var string */
    protected $entityName;

    /** @var EntityManager */
    protected $entityManager;

    /** @var EntityRepository */
    protected $repository;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator = null;

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

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}