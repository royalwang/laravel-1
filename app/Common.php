<?php 

namespace App;

//use App\Common\Header;
//use App\Common\Footer;
//use App\Common\Sidebar;
//use App\Common\Htmlheader;


class Common  {
    public $data;
  

    public function __construct($user){
        //$this->data['header']     = new Header;
        //$this->data['footer']     = new Footer;
        //$this->data['sidebar']    = new Sidebar;
        //$this->data['htmlheader'] = new Htmlheader;

        $this->data['sidebar'] = [
            'home'             => ['show' => true , 'active' => false , 'url' => 'home' , 'icon'=> 'fa-table'],
            'ad_user'          => ['show' => false , 'active' => false , 'url' => 'users' , 'icon'=>'fa-users'],
            'ad_account'       => ['show' => false , 'active' => false , 'url' => 'account', 'icon'=> 'fa-list-alt'],
            'ad_table_style'   => ['show' => false , 'active' => false , 'url' => 'adtablestyle' , 'icon' => 'fa-bar-chart'],
            'ad_account_style' => ['show' => false , 'active' => false , 'url' => 'adaccountstyle' , 'icon' => 'fa-list-ol'],
            'setting'          => ['show' => true , 'active' => false , 'url' => 'setting' , 'icon' => 'fa-cog'],
        ];

        if($user->is('responsible')){
            $this->setVisable('sidebar',['home','ad_user','ad_account','ad_table_style']);
        }elseif($user->is('advertising')){
            $this->setVisable('sidebar',['home','ad_table_style','ad_account_style']);
        }
          
    }

    public function setVisable($obj,$key){
        foreach($key as $k){
            if(isset($this->data[$obj][$k])) $this->data[$obj][$k]['show'] = true;
            continue;
        }
        return $this;
    }

    public function setInvisable($obj,$key){
        foreach($key as $k){
            if(isset($this->data[$obj][$k])) $this->data[$obj][$k]['show'] = false;
            continue;
        }
        return $this;
    }

    public function setActive($obj, $key = ''){
        if(!isset($this->data[$obj])) return $this;
        foreach($this->data[$obj] as $k=>$value){      
            $this->data[$obj][$k]['active'] = ($k == $key) ? true : false;
        }
        return $this;
    }

    public function __set($name,CommonInter $class){
        if(!isset($this->data[$name])) $this->data[$name] = $class;
    }

    public function __unset($name) {
        unset($this->data[$name]);
    }

    public function __get($name){
        return isset($this->data[$name]) ? $this->getShow($this->data[$name]) : array();
    }

    private function getShow($data){
        return array_filter( $data, function($v){ return $v['show'] ; });
    }

    public function get(){
        return $this;
    }


    

}
