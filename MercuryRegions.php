<?php
/**
 * Helper class to encapsulate Mercury Region data 
 *
 * @author Jonas Flodén
 */

namespace Koala\ContentBundle;

class MercuryRegions implements \ArrayAccess, \Iterator
{
    var $regions;
    var $keys;

    function __construct($content)
    {
        $this->regions = json_decode($content, true);
    }

    public function offsetExists($offset)
    {
        return isset($this->regions[$offset]);
    }

    public function offsetGet($offset)
    {
        $region = $this->regions[$offset];
        switch ($region["type"])
        {
        case "image":
            return $region['attributes']['src'];
        default:
            return $region['value'];
        }
    }

    public function offsetSet($offset, $value)
    {
        $this->regions[$offset] = array('type'=>'simple', 'value'=>$value);
    }

    public function offsetUnset($offset)
    {
        unset($this->regions[$offset]);
    }

    public function rewind()
    {
        $this->keys = array_keys($this->regions);
        reset($this->keys);
    }

    public function current()
    {
        $offset = current($this->keys);
        return $this[$offset];
    }

    public function key()
    {
        return current($this->keys);
    }

    public function next()
    {
        next($this->keys);
    }

    public function valid()
    {
        return ($this->key() !== FALSE);
    }
}
