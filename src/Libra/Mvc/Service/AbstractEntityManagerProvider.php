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

/**
 * AbstractObjectManagerProveder prefer over
 * Class AbstractEntityManagerProvider
 * @package Libra\Mvc\Service
 */
abstract class AbstractEntityManagerProvider implements ServiceLocatorAwareInterface
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var EntityRepository */
    protected $repository;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator = null;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
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

    /**
     * @return \Doctrine\ORM\EntityRepository
     * @throws RuntimeException
     */
    public function getRepository()
    {
        if ($this->getEntityName() === null) {
            throw new RuntimeException('No Entity Name specified');
        }
        if ($this->repository === null) {
            $this->repository = $this->getEntityManager()->getRepository($this->getEntityName());
        }

        return $this->repository;
    }

    /**
     * @abstract
     * @return string Entity Class Name
     */
    abstract public function getEntityName();

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