<?php

namespace Bernhardh\NovaDynamicViews;

class CustomComponents implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $class;
    /**
     * @var array
     */
    protected $items = [];
    
    
    /**
     * @param string $class
     *
     * @return static
     */
    public static function make($class = '')
    {
        $obj = new static();
        $obj->class = $class;
        
        return $obj;
    }
    
    
    /**
     * @param string $name
     * @param array $meta
     *
     * @return $this
     */
    public function addItem($name, $meta = [])
    {
        $item = ['name'=> $name];
        if($meta) {
            $item['meta'] = $meta;
        }
        
        $this->items[] = $item;
        
        return $this;
    }
    
    
    /**
     * @param string $class
     *
     * @return CustomComponents
     */
    public function setClass(string $class) {
        $this->class = $class;
        
        return $this;
    }
    
    
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return array_filter([
            'class' => $this->class,
            'items' => $this->items
        ]);
    }
}
