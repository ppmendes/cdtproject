<?php
/**
 * Created by JetBrains PhpStorm.
 * User: work
 * Date: 30/10/12
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

require_once 'Zend/Filter/Interface.php';

class Zend_Filter_DateFilter implements Zend_Filter_Interface
{
    public function filter($value = null)
    {
        // perform some transformation upon $value to arrive on $valueFiltered
        if($value != null && $value != '0000-00-00 00:00:00' && $value != '0000-00-00'){
                if(strpos($value,'/') !== false){
                    $data_array = explode('/',$value);
                    return $data_array[2].'-'.$data_array[1].'-'.$data_array[0];
                }else{
                    return date('d/m/Y',strtotime($value));
                }
        }else{
            return null;
        }
    }
}
?>