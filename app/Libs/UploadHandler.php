<?php

namespace App\Libs;
/*
 * jQuery File Upload Plugin PHP Class
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

use App\Libs\PHPExcel;

class UploadHandler
{

    protected $options;
    private $files;

    // PHP File Upload error message codes:
    // http://php.net/manual/en/features.file-upload.errors.php

    protected $image_objects = array();

    public function __construct($options = null) {
        $this->response = array();
        $this->options = array(
            'accept_file_types' => '/\.(csv)$/i',
        );
        $this->initialize();
    }

    protected function initialize() {
        $files = array();
        foreach($_FILES['files']['tmp_name'] as $key=>$file){
            $path = $file
            $name = basename($file);
            if (preg_match($this->options['accept_file_types'], $file->name , $matches)) {
                $files[] = array(
                    'name' => $name,
                    'path' => $path,
                    'type' => $matches[1],
                );
            }
        }
        $this->files;
    }

    public function toArray(){
        $data = array();
        foreach ($this->files as $file) {
            switch ($file['type']) {
                case 'csv':
                        $csv = array_map('str_getcsv', file($file));
                        array_walk($csv, function(&$a) use ($csv) {
                          $a = array_combine($csv[0], $a);
                        });
                        array_shift($csv); 
                        return $csv;
                    break;
                case 'xlsx';
                    $data += $this->readEXCEL($file['path']);
                    break;    
                case 'txt':
                default:
                    $data += $this->readTEXT($file['path']);
                    break;
            }
        }
        return $data;
    }


    public function readEXCEL($file){

    }

    public function readTEXT($file){

    }
}
