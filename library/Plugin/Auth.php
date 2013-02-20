<?php
class Plugin_Auth extends Zend_Controller_Plugin_Abstract{
    public function preDispatch($request){
        /* Verifica se o usuário não está logado */
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $request->setControllerName('index');
            $request->setActionName('index');
        }else{
            $data = Zend_Auth::getInstance()->getStorage()->read();
            $permissoes = $data->permissoes;
            $request->getControllerName();
            $request->getActionName();
        }
    }
}
?>