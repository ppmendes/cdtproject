<?php

class Application_Model_Usuario
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Usuario();
        $usuario = $table->find($id)->current();
        return $usuario;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Usuario;
            $usuario = $table->fetchAll();
            foreach($usuario as $item){
                $options[$item['usuario_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
    public static function getOptions1($id_projeto_form = null){
        try{
            if($id_projeto_form == null)
            {
                $options = array();
                return $options;
            }
            else
            {
                //$options = array();

                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select usuario.usuario_id, usuario.nome from usuario inner join projeto_usuario on usuario.usuario_id = projeto_usuario.usuario_id where projeto_id = $id_projeto_form");

                foreach($resultado as $item){

                    $options[$item['usuario_id']] = $item['nome'];
                }
                return $options;
           }
        } catch(Exception $e){

        }

    }

    public static function getOptions2($id_projeto_form = null, $id_tarefa_form=null){
        try{
            if($id_projeto_form == null)
            {
                $options = array();
                return $options;
            }
            else
            {
                $options = array();
                //

                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado_usu = $db->fetchAll("select U.usuario_id from Usuario as U inner join usuarios_associados_tarefa as UAT on U.usuario_id=UAT.usuario_id where UAT.tarefa_id=$id_tarefa_form");

                $id=array();
                foreach($resultado_usu as $item_usu)
                {
                    $id[]=$item_usu['usuario_id'];
                }
                $id=implode(',',$id);

                $resultado = $db->fetchAll("select usuario.usuario_id, usuario.nome from usuario inner join projeto_usuario on usuario.usuario_id = projeto_usuario.usuario_id where projeto_id = $id_projeto_form and usuario_id not in ($id)");

                print_r($resultado);
                exit;
                       foreach($resultado as $item){

                           $options[$item['usuario_id']] = $item['nome'];
                       }
                       return $options;
                }
        } catch(Exception $e){

        }

    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Usuario;
        $table->insert($data['usuario']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "usuario";
        $deletado = true;
        $where = $db->quoteInto('usuario_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);
    }

    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Usuario;
        $where = $table->getAdapter()->quoteInto('usuario_id = ?',$id);

        $table->update($data['usuario'], $where);
    }

    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            // ainda resta apresentar historico de login do usuarios
            $select = $db->select()
                ->from(array('u'=>'usuario'))
                ->where('u.deletado=?',false)
                ->where('u.tipo_usuario = ?', "usuario")
                ->joinLeft(array('i'=>'instituicao'),'u.instituicao_id = i.instituicao_id',array('u.usuario_id'=>'u.usuario_id','u.sobrenome'=>'u.sobrenome','u.nome'=>'u.nome','i.nome'=>'i.nome'));

            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        } catch(Exception $e){
            Zend_Registry::get('Log')->log($e->getMessage(),Zend_Log::DEBUG);
        }
    }

    public function selectAllcontatos()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            // ainda resta apresentar historico de login do usuarios
            $select = $db->select()
                ->from(array('u'=>'usuario'))
                ->where('u.deletado=?',false)
                ->joinLeft(array('i'=>'instituicao'),'u.instituicao_id = i.instituicao_id',array('u.usuario_id'=>'u.usuario_id','u.sobrenome'=>'u.sobrenome','u.nome'=>'u.nome','i.nome'=>'i.nome'));

            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        } catch(Exception $e){
            Zend_Registry::get('Log')->log($e->getMessage(),Zend_Log::DEBUG);
        }
    }

    public function verificarMudancasArquivos($data,$id)
    {
        //$data dados do formulario atual, e o id
        $nome_icone=$data['usuario']['icone'];

        $db = Zend_Db_Table::getDefaultAdapter();
        $result=$db->fetchRow("select icone from usuario where usuario_id=$id");

        // mudancas no arquivo bb
        if($nome_icone!="")
        {
            //quer dizer mudaram de imagem
            //definindo origem
            $origem='files/usuarios/imagens/'.$result['icone'];
            //definindo destino
            $destino='files/lixeira/'.$result['icone'];

            //copiando arquivo a  lixeira
            copy($origem,$destino);
            unlink($origem);

            //edita novo nome da imagem e faz upload da imagem
            $newdata=$this->editarImagem($id,$data);
            return $newdata;
        }else{
            return $data;
        }
    }

    public function getLastInsertedId(){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(usuario_id) FROM usuario");
        return (int)$result+1;
    }

    public function editarNomeImagem($nomeImagem)
    {
        $upload = new Zend_File_Transfer_Adapter_Http();

        $pathimagem = 'files/usuarios/imagens';
        //Verificando a existencia da ruta
        if(!file_exists($pathimagem))
        {
            mkdir($pathimagem, 0777);
        }
        // $pasta retorna a ruta da pasta
        $upload->addFilter('Rename', $pathimagem);

        //pegando o formato do arquivo
        $file = $upload->getFileName('icone');
        $formato = explode(".",$file);
        $indice = count($formato)-1;

        //renomeando o arquivo
        $renomeado='usuario_'.$nomeImagem.'.'.$formato[$indice];
        $fullFilePathFile = $pathimagem.'/'.$renomeado;
        $filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePathFile, 'overwrite' => true));
        $filterFileRename -> filter($file);
        return $renomeado;
    }

    public function editarImagem($nome_imagem,$data)
    {

        $upload = new Zend_File_Transfer_Adapter_Http();

        $pathimagem = 'files/usuarios/imagens';
       //Verificando a existencia da ruta
        if(!file_exists($pathimagem))
        {
                mkdir($pathimagem, 0777);
        }
        // $pasta retorna a ruta da pasta
        $upload->addFilter('Rename', $pathimagem);

        //pegando o formato do arquivo
        $file = $upload->getFileName('icone');
        //$file = $data['usuario']['icone'];


             try {
                // upload received file(s)
                $upload->receive();
                $formato = explode(".",$file);
                $indice = count($formato)-1;

                //renomeando o arquivo
                $renomeado='usuario_'.$nome_imagem.'.'.$formato[$indice];
                $fullFilePathFile = $pathimagem.'/'.$renomeado;
                $filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePathFile, 'overwrite' => true));
                $filterFileRename -> filter($file);

                $data['usuario']['icone']=$renomeado;

            } catch (Zend_File_Transfer_Exception $e) {
                $e->getMessage();
            }
            return $data;
    }

    public function paeFilhos($id_pai)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $result=$db->query("CALL sp_recursive_start($id_pai)");
        return $result->fetchAll();
    }

    public function criarTreeview($array)
    {
        $nroElementos=count($array);
        $nivel=1;

        $nome = $array[0]["nome"];
        $id = $array[0]["id"];

        echo '<ul id="red"><li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[0]['nome'].'</a>';


        for($i=1;$i<$nroElementos;$i++)
        {
            $novonivel=$array[$i]['geracao'];

            $nome = $array[$i]['nome'];
            $id = $array[$i]['id'];

            if($novonivel==$nivel)
            {
                echo'</li><li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';

            }
            elseif($novonivel>$nivel)
            {
                echo'<ul>';
                echo'<li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';
                $nivel=$novonivel;
            }
            elseif($novonivel<$nivel)
            {
                $nro=$nivel-$novonivel;
                echo'</li>';
                $this->fecharnivel($nro);
                echo'<li><a onClick="retornaId(\''.$nome.'\','.$id.')">'.$array[$i]['nome'].'</a>';
                $nivel=$novonivel;
            }

        }
        $this->fecharnivel($nivel);


    }

    public function fecharnivel($nivel)
    {
        for($i=0;$i<$nivel;$i++)
        {
            echo'</ul></li>';
        }
    }

    public function retornaPais()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            // ainda resta apresentar historico de login do usuarios
            $select = $db->select()
                ->from('instituicao',
                array('instituicao_id', 'nome'))
                ->where('pai_id=?',0);

            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        } catch(Exception $e){
            Zend_Registry::get('Log')->log($e->getMessage(),Zend_Log::DEBUG);
        }
    }
}

