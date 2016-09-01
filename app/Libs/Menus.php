<?php 

namespace App\Libs;

class MenuItem{
    private $child;
    private $url;
    private $icon;
    private $name;
    private $active;
    private $visable;
    
    public function __construct($array){
        $this->url      = isset($array['url'])?$array['url']:'';
        $this->icon     = isset($array['icon'])?$array['icon']:'';
        $this->name     = isset($array['name'])?$array['name']:'';
        $this->visable  = isset($array['visable'])?$array['visable']:'';
        
        if(isset($array['child']) && is_array($array['child'])){
            $this->setChild($array['child']);
        }
    }
    public function toArray(){
        $array = array(
            'url' => $this->url,
            'icon' => $this->icon,
            'name' => $this->name,
            'active' => $this->active,
            'visable' => $this->visable,
        );
        if($this->child instanceof Menus){
            $array['child'] = $this->child->toArray();
        }
        return $array;
    }

    public function setChild($array){
        $this->child = new Menus($array);
    }

    public function setActive(){
        $this->active = 'active';
    }

    public function setVisable(){
        $this->visable = 'visable';
    }
    
    public function addMenu($key,$array){
        if($this->child instanceof Menus){
            $this->child->addMenu($key,$array);
        }   
    }
    public function getMenu(){
        return $this->child;
    }
}

class Menus{
    private $items;

    public function __construct($array = array()){
        if(empty($array)) return $this;
        foreach($array as $key=>$value){
            $this->items[$key] = new MenuItem($value);
        }
    }

    public function addItems($array){
        foreach($array as $key=>$value){
            $this->items[$key] = new MenuItem($value);
        }
        return $this;
    }

    public function addMenu($key,$array){
        
        $keys = explode('.', $key,2);
        $code = array_shift($keys);

        if(!isset($this->items[$code])) return;

        if(is_array($keys) && !empty($keys) ){
            $this->items[$code]->addMenu($keys[0], $array);
        }else{
            $this->items[$code]->setChild($array);
        }       
        
        return $this;
    }  
    
    public function toArray(){
        $array = array();
        foreach($this->items as $key=>$value){
            $array[$key] = $value->toArray();
        }
        return $array;
    }
    
    public function getMenu($key = ''){
        $keys = explode('.', $key,2);
        $code = array_shift($keys);

        if(!isset($this->items[$code]) || empty($key)) return $this;
        
        $child_menu = $this->items[$code]->getMenu();
        
        if(isset($keys[0]) && !empty($keys[0])){
            return $child_menu->getMenu($keys[0]);
        }
        
        return $child_menu;   
    }
    
    public function setActive($key){
        $keys = explode('.', $key,2);
        $code = array_shift($keys);

        if(!isset($this->items[$code])) return $this;

        $this->items[$code]->setActive();
        
        if(is_array($keys) && !empty($keys) ){
            $child_menu = $this->items[$code]->getMenu();
            if($child_menu instanceof Menus) $child_menu->setActive($keys[0]);
        }     

        return $this;
    }

    public function setVisable($key){
        $keys = explode('.', $key,2);
        $code = array_shift($keys);

        if(!isset($this->items[$code])) return $this;

        $this->items[$code]->setVisable();
        
        if(is_array($keys) && !empty($keys) ){
            $child_menu = $this->items[$code]->getMenu();
            if($child_menu instanceof Menus) $child_menu->setVisable($keys[0]);
        }     

        return $this;
    }
    
}