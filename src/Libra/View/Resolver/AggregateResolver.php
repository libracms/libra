<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace Libra\View\Resolver;

use Zend\View\Resolver\AggregateResolver as BaseAggregateResolver;
use Zend\View\Renderer\RendererInterface as Renderer;

/**
 * Description of TemplatePathStack
 *
 * @author duke
 */
class AggregateResolver extends BaseAggregateResolver
{
    /*
     * add search in that folder
     */
    public function resolve($name, Renderer $renderer = null)
    {
        $result = parent::resolve($name, $renderer);
        if ($result === false) {
            //search inside current template
            $helper = $renderer->plugin('view_model');
            $currentTemplate = $helper->getCurrent()->getTemplate();
            $length = strrpos($currentTemplate, '/');
            if ($length > 0) {
                $name = substr($currentTemplate, 0, $length) . '/' . $name;
                $result = parent::resolve($name, $renderer);
            }
        }
        return $result;
    }

}
