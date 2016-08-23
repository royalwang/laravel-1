<?php 

namespace App\Libs;





class Menu{
    private $item = array();
    private $parent;

    function __consturct(){
        $this->parent = null;
    }

    function setParent(MenuItem $parent){
        $this->parent = $parent;
    }

    function addItem(MenuItem $item){
        $this->item[] = $item;
        $item->setParent($this);
    }

    function setActive(){
        $this->parent->setActive();
    }
}

class CommonInterface{
	private $data
    function set($code,$name,$url = ''){
    	$this->data['code'] = $code;
    	$this->data['name'] = $name;
    	$this->data['url']  = $url;
    }
}




class Common  {
	public $date;

	public function __construct(){
	}

    public function set($code,$data)
    {
        $this->data[$code] = $data;
    }

    public function get($code)
    {
        $this->data[$code] = $data;
    }

}

