<?php

/*
 * Copyright (c) 2008-2012 eJoom Software
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the eJoom Software nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY EJOOM SOFTWARE ``AS IS`` AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Libra\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Parameters;

/**
 * Add params field to entity. There you can put any number of field.
 * Useful for entities with unlimited fields that won't be indexed.
 *
 * @author duke
 */
class AbstractEntityParams
{
    /**
     * @ORM\Column(type="parameters", nullable=true)
     * @var \Zend\Stdlib\Parameters
     */
    protected $params;

    public function __construct()
    {
        $this->params = new Parameters;
    }

    public function getParams()
    {
        //Doctrine get it from DB as array. So transform to Parameters
        if (is_array($this->params)) {
            $this->params = new Parameters($this->params);
        }

        return $this->params;
    }

    /**
     * Set Params instance to entity
     * @param Parameters|array $params
     * @return \Libra\Entity\AbstractEntityParams
     */
    public function setParams($params)
    {
        if ($params instanceof Parameters) {
            $this->params = $params;
        } elseif (is_array($params)) {
            $this->params = new Parameters($params);
        } elseif (is_object($params)) {
            $this->params = new Parameters((array)$params);
        } else {
            throw new Exception(sprintf('"%s" isn\'t an array or Parameters instance', $params));
        }

        return $this;
    }

    /**
     * @deprecated since version 0.4. Use getParams()->get($name, default) instead.
     * @param type $name
     * @param type $default
     * @return type
     */
    public function getParam($name, $default = null)
    {
        if (!isset($this->params[$name])) {
            return $default;
        }
        return $this->params[$name];
    }

}
