<?php

namespace Libra\Mvc\Service;

use Libra\View\Resolver as ViewResolver;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewResolverFactory implements FactoryInterface
{
    /**
     * Create the aggregate view resolver
     *
     * Creates a Zend\View\Resolver\AggregateResolver and attaches the template
     * map resolver and path stack resolver
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewResolverAggregateResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resolver = new ViewResolver\AggregateResolver();
        $resolver->attach($serviceLocator->get('ViewTemplateMapResolver'));
        $resolver->attach($serviceLocator->get('ViewTemplatePathStack'));
        return $resolver;
    }
}
