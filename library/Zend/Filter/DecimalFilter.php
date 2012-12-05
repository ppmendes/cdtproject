<?php
/**
 * Created by JetBrains PhpStorm.
 * User: work
 * Date: 30/10/12
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

require_once 'Zend/Filter/Interface.php';

class Zend_Filter_DecimalFilter implements Zend_Filter_Interface
{
    public function filter($value = null)
    {
        // perform some transformation upon $value to arrive on $valueFiltered
        if($value != null && $value != 0 ){
                if(strpos($value,'.') !== false){
                    return str_replace('.',',',$value);
                }else{
                    return str_replace(',','.',$value);
                }
        }else{
            return null;
        }
    }
}
?>