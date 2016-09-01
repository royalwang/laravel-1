<?php 


function menu($data){
    $html = '';
    foreach($data as $value){
        if(!isset($value['visable']) || empty($value['visable'])) continue; 
        $html .= '<li class="' . (isset($value['active'])?'active':'') .'">';
        if(isset($value['url']) && !empty($value['url'])){
             $html .= '<a href="'. route($value['url']) .'">';
         }else{
             $html .= '<a>';
         }
       
        $html .= '<i class="fa '.$value['icon'].'"></i>';
        $html .= '<span>'.$value['name'].'</span>';

        if(isset($value['child']) && is_array($value['child'])){
            $html .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html .= '<ul class="treeview-menu">' . menu($value['child']) . '</ul>';
        }else{
            $html .= '</a>';
        }
        $html .= '</li>';
    }
    
    return $html;
}


?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <?php echo menu($sidebar_main); ?>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
