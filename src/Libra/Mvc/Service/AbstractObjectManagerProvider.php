<?php
/**
 * User: duke.
 * Date: 7/4/13
 * Time: 2:32 PM
 */

namespace Libra\Mvc\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Mvc\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractObjectManagerProvider
 * @package Libra\Mvc\Service
 */
abstract class AbstractObjectManagerProvider implements ServiceLocatorAwareInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var ObjectRepository */
    protected $repository;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator = null;

    public function getObjectManager()
    {
        if ($this->objectManager === null) {
            $this->objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->objectManager;
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        return $this;
    }

    public function getRepository()
    {
        if ($this->getObjectClassName() === null) {
            throw new RuntimeException('No Object Class Name specified');
        }
        if ($this->repository === null) {
            $this->repository = $this->getObjectManager()->getRepository($this->getObjectClassName());
        }

        return $this->repository;
    }

    /**
     * @abstract
     * @return string Object Class Name
     */
    abstract public function getObjectClassName();

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