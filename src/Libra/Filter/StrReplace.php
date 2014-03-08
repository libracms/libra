<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace Libra\Filter;

use Zend\Filter\AbstractFilter;

class StrReplace extends AbstractFilter
{
    /**
     * @var array
     */
    protected $options = array(
        'search' => null,
        'reaplace' => null,
    );

    /**
     * Constructor
     * Supported options are
     *     'search'     => matching pattern
     *     'replace' => replace with this
     *
     * @param  array|Traversable|string|null $options
     */
    public function __construct($options = null)
    {
        if ($options instanceof Traversable) {
            $options = iterator_to_array($options);
        }

        if (!is_array($options)
            || (!isset($options['search']) && !isset($options['replace'])))
        {
            $args = func_get_args();
            if (isset($args[0])) {
                $this->setSearch($args[0]);
            }
            if (isset($args[1])) {
                $this->setReplace($args[1]);
            }
        } else {
            $this->setOptions($options);
        }
    }

    /**
     * Set the search string
     * @see str_replace()
     *
     * @param  string|array $search - same as the first argument of preg_replace
     * @return self
     * @throws Exception\InvalidArgumentException
     */
    public function setSearch($search)
    {
        if (!is_array($search) && !is_string($search)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects search to be array or string; received "%s"',
                __METHOD__,
                (is_object($search) ? get_class($search) : gettype($search))
            ));
        }

        $this->options['search'] = $search;
        return $this;
    }

    /**
     * Get currently set search
     *
     * @return string|array
     */
    public function getSearch()
    {
        return $this->options['search'];
    }

    /**
     * Set the replace array/string
     * @see str_replace()
     *
     * @param  array|string $replace - same as the second argument of str_replace
     * @return self
     * @throws Exception\InvalidArgumentException
     */
    public function setReplace($replace)
    {
        if (!is_array($replace) && !is_string($replace)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects replace to be array or string; received "%s"',
                __METHOD__,
                (is_object($replace) ? get_class($replace) : gettype($replace))
            ));
        }
        $this->options['replace'] = $replace;
        return $this;
    }

    /**
     * Get currently set replace string
     *
     * @return string|array
     */
    public function getReplace()
    {
        return $this->options['replace'];
    }

    /**
     * Defined by Zend\Filter\FilterInterface
     *
     * Replace string with another string
     *
     * @param  mixed $value
     * @return mixed
     * @throws Exception\RuntimeException
     */
    public function filter($value)
    {
        if ($this->options['search'] === null) {
            throw new Exception\RuntimeException(sprintf(
                'Filter %s does not have a valid search set',
                get_class($this)
            ));
        }

        return str_replace($this->options['search'], $this->options['replace'], $value);
    }
}