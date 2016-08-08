<?php 
namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    protected $default_data = array(
        'e'      => 0,
        'e_msg'  => '',
        'd'      => array(),
    );
}    