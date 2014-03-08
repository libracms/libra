<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace Libra\Filter;

use Zend\Filter\AbstractFilter;

class StripCarriageReturn extends AbstractFilter
{
    /**
     * Defined by Zend\Filter\FilterInterface
     *
     * Returns $value without CR control characters
     * Useful for textarea form element
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        return str_replace("\r", '', $value);
    }
}