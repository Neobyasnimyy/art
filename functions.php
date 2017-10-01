<?php

function debug($arr){
    echo '<pre>'.print_r($arr,true).'</pre>';

}

function myDelete($path)
{
    if(is_file($path)){
        unlink($path);
    }elseif (is_dir($path)){
        if ($objs = glob($path."/*"))
        {
            foreach($objs as $obj)
            {
                is_dir($obj) ? $this->delTree($obj) : unlink($obj);
            }
        }
        rmdir($path);
    }


}