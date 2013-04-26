<?php
class Plugin_Auth extends Zend_Controller_Plugin_Abstract{
    private function redireciona(Zend_Controller_Request_Abstract $request, $controller = null, $action = null){
        if($controller !== null && $action != null){
            $request->setControllerName($controller);
            $request->setActionName($action);
        }else if($controller !== null){
            $request->setControllerName($controller);
            $request->setActionName('index');
        }
        else{
            $request->setControllerName('index');
            $request->setActionName('index');
        }
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request){
        /* Verifica se o usuário não está logado */
        if(!Zend_Auth::getInstance()->hasIdentity()){
            //Redireciona para index se não estiver logado
            $this->redireciona($request);
        }else{
            //Busca na sessão
            $data = Zend_Auth::getInstance()->getStorage()->read();

            //array com as permissões do usuário
            $permissoes = $data->permissoes;


            //controlador, ação e parâmetros da url acessada
            $controller = $request->getControllerName();
            $acao = $request->getActionName();
            $parametros = $request->getParams();

            if(isset($parametros['projeto_id'])){
                $projeto_id = $parametros['projeto_id'];
            }else{
                $projeto_id = '*';
            }

            $permitirAcesso = false;
            if($controller == 'index'){
                $permitirAcesso = true;
            }
            if($acao=='treeview' || $acao=='treeviewpermissoes')
            {
                $permitirAcesso=true;
            }

            if(isset($permissoes[$controller][$acao][$projeto_id])
                && $permissoes[$controller][$acao][$projeto_id] === true){
                $permitirAcesso = true;
            }else if(isset($permissoes[$controller][$acao]['*'])
                && $permissoes[$controller][$acao]['*'] === true){
                $permitirAcesso = true;
            }else if(isset($permissoes[$controller][$acao]['#'])
                && $permissoes[$controller][$acao]['#']==true){
                $permitirAcesso=true;
            }else if(isset($permissoes[$controller]['*']['*'])
                && $permissoes[$controller]['*']['*'] === true){
                $permitirAcesso = true;
            }else if(isset($permissoes['*']['*']['*'])
                && $permissoes['*']['*']['*'] === true){
                $permitirAcesso = true;
            }

            if($permitirAcesso === false){
                //se não possui permissão redireciona para index
                $this->redireciona($request,'index','permissiondenied');
            }


        }
    }
}
?>