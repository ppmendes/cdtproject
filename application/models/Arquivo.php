<?php

class Application_Model_Arquivo
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Arquivo;
        $arquivo = $table->find($id)->current();
        return $arquivo;
    }

    public function insert($data)
    {
        $data['arquivos']['data_arquivo'] = date('Y-m-d h:i:s', time());
        unset($data['arquivos']['nomeProjeto']);
        $table = new Application_Model_DbTable_Arquivo;
        $table->insert($data['arquivos']);
    }

    public function delete($id)
    {
       $db=$db1 = Zend_Db_Table::getDefaultAdapter();
        $table = "arquivo";
        $deletado = true;
        $where = $db->quoteInto('arquivo_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);


        //deletando fisicamente o arquivo
        $result=$db1->fetchRow("select nome_arquivo, projeto_id, tarefa_id from arquivo where arquivo_id=$id");
        //obtendo o endereco do aqrquivo
        if($result['tarefa_id']){//
            $origen='files/arquivos/projeto-'.$result['projeto_id'].'/tarefa-'.$result['tarefa_id'].'/'.$result['nome_arquivo'];

        }
        else{//caso nao tenha tarefa
            $origen='files/arquivos/projeto-'.$result['projeto_id'].'/'.$result['nome_arquivo'];
        }
        $destino='files/lixeira/'.$result['nome_arquivo'];
        copy($origen,$destino);
        $this->eliminarPasta('files/arquivos',$origen);

    }

    function eliminarPasta($pasta, $nome)
    {
        foreach(glob($pasta . "/*") as $arquivo_pasta)
        {
            //echo $archivos_carpeta;

            if (is_dir($arquivo_pasta))
            {
                //echo'entro dir';
                $this->eliminarPasta($arquivo_pasta, $nome);
                $nro=$this->contarArquivos($arquivo_pasta);
                //echo $nro;
                if($nro===0)
                {
                    //echo 'borrando archivo';
                    rmdir($arquivo_pasta);
                }
            }
            elseif($arquivo_pasta==$nome)
            {
                //echo'entro unlink......';
                unlink($arquivo_pasta);
            }
        }

    }
    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Arquivo;
        $where = $table->getAdapter()->quoteInto('arquivo_id = ?',$id);
        unset($data['arquivos']['nomeProjeto']);
        $table->update($data['arquivos'], $where);
    }

    public function getLastInsertedId(){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(arquivo_id) FROM arquivo");
        return (int)$result+1;
    }

    public function recuperarVersao($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("Select versao from arquivo where arquivo_id= $id");
        return $result;
    }

    public function  incrementaVersao($versao)
    {
        $versao = $versao + 0.1;
        return $versao;
    }

    public function existePasta($projetoid, $tarefaid)
    {
        $pathprojeto = 'files/arquivos/projeto-'.$projetoid;

        $pathtarefa=$pathprojeto.'/tarefa-'.$tarefaid;

        if(file_exists($pathprojeto))
        {
            if($tarefaid)
            {
                if(file_exists($pathtarefa))
                {
                    return $pathtarefa;
                }else
                {
                    mkdir($pathtarefa, 0777);
                    return $pathtarefa;
                }
            }
            else{
                return $pathprojeto;
            }
           // buscar pasta tarefas

        }else{
            // criar pasta projeto
            mkdir(''.$pathprojeto, 0777);
            if($tarefaid)
            {
                mkdir($pathtarefa, 0777);
                return $pathtarefa;
            }
            else{
                return $pathprojeto;
            }

        }
    }

    public function verificarMudancasArquivos($data,$id)
    {

        $nome=$data['arquivos']['nome_arquivo'];
        $projetoid=$data['arquivos']['projeto_id'];
        $tarefaid=$data['arquivos']['tarefa_id'];

        $db = Zend_Db_Table::getDefaultAdapter();
        $result=$db->fetchRow("select nome_arquivo, tamanho, projeto_id, tarefa_id from arquivo where arquivo_id=$id");

        // mudancas no arquivo
        if($nome!="")
        {


            $origem=$this->existePasta($result['projeto_id'],$result['tarefa_id']).'/'.$result['nome_arquivo'];
            $destino='files/lixeira/'.$result['nome_arquivo'];
            copy($origem,$destino);
            $this->eliminarPasta('files/arquivos',$origem);//unlink($origem);

            $data['arquivos']['tamanho']=-1;
            $data=$this->editarArquivo($id,$data);
            return $data;
        }
        // so muda de pasta projeto ou tarefa
        elseif(($projetoid!=$result['projeto_id'])||($tarefaid!=$result['tarefa_id']))
        {

            $origem=$this->existePasta($result['projeto_id'],$result['tarefa_id']).'/'.$result['nome_arquivo'];
            $destino=$this->existePasta($projetoid, $tarefaid).'/'.$result['nome_arquivo'];

            copy($origem,$destino);
            $this->eliminarPasta('files/arquivos',$origem);//unlink($origem);

            // so muda de pasta projeto ou tarefa


            //$this->deletadoFisico($id);
            $data['arquivos']['nome_arquivo']=$result['nome_arquivo'];
            return $data;

        }
        else{
            $data['arquivos']['nome_arquivo']=$result['nome_arquivo'];
            return $data;
        }

    }

    public function deletadoFisico($id)
    {
        $db= Zend_Db_Table::getDefaultAdapter();
        $result=$db->fetchRow("select nome_arquivo, projeto_id, tarefa_id from arquivo where arquivo_id=$id");
        //obtendo o endereco do aqrquivo
        if($result['tarefa_id']){//
            $origem='files/arquivos/projeto-'.$result['projeto_id'].'/tarefa-'.$result['tarefa_id'].'/'.$result['nome_arquivo'];
        }
        else{//se não tiver tarefa
            $origem='files/arquivos/projeto-'.$result['projeto_id'].'/'.$result['nome_arquivo'];
        }
        //obtendo o enderco da lixeira
        $destino='files/lixeira/'.$result['nome_arquivo'];
        copy($origem,$destino);
        $this->eliminarPasta('files/arquivos',$origem);
    }

    public function contarArquivos($path)
    {
        $ds  = opendir($path);
        while (false !== ($nombre_archivo = readdir($ds))) {
            $archivos[] = $nombre_archivo;
        }
        $total_archivos = count($archivos);
        $total = $total_archivos-2;
        return $total;
    }

    public function editarArquivo($nome_arquivo,$data)
    {

        $upload = new Zend_File_Transfer_Adapter_Http();

        //variaveis para criar o nome do arquivo
        $projetoid = $data['arquivos']['projeto_id'];
        $tarefaid = $data['arquivos']['tarefa_id'];
        $versao = $data['arquivos']['versao'];
        //verificar se tem tarefa
        if(!$tarefaid)
        {
            unset($data['arquivos']['tarefa_id']);
        }
        //criar as pastas
        $pasta=$this->existePasta($projetoid, $tarefaid);
        $upload->addFilter('Rename', $pasta);

        try {
            // upload received file(s)
            $upload->receive();

        } catch (Zend_File_Transfer_Exception $e) {
            $e->getMessage();
        }

        //pegando o formato do arquivo
        $file = $upload->getFileName('nome_arquivo');
        $formato = explode(".",$file);
        $indice = count($formato)-1;

        //renomeando o arquivo
        $renomeado='arquivo_'.$nome_arquivo.'_'.$versao.'.'.$formato[$indice];
        $fullFilePathFile = $pasta.'/'.$renomeado;
        $filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePathFile, 'overwrite' => true));
        $filterFileRename -> filter($file);


        $data['arquivos']['nome_arquivo']=$renomeado;

        return $data;
    }

    public function selectAll()
    {
       try{
           $db = Zend_Db_Table::getDefaultAdapter();

           $select = $db->select()
               ->from(array('a' => 'arquivo'), array('a.arquivo_id'=>'a.arquivo_id', 'a.nome_arquivo'=>'a.nome_arquivo', 'a.versao'=>'a.versao', 'a.tamanho'=>'a.tamanho', 'a.data_arquivo'=>'a.data_arquivo', 'a.descricao_arquivo'=>'a.descricao_arquivo', 'a.nome_real'=>'a.nome_real', 'a.projeto_id'=>'a.projeto_id'))
               ->where('a.deletado = ?', false)
               ->joinLeft(array('t' => 'tarefa'), 'a.tarefa_id = t.tarefa_id', array('t.nome'=>'t.nome','t.tarefa_id'=>'t.tarefa_id'))
               ->joinLeft(array('ta' => 'tipo_arquivo'), 'a.tipo_arquivo_id = ta.tipo_arquivo_id', array('ta.nome_tipo'=>'ta.nome_tipo'))
               ->joinLeft(array('u' => 'usuario'), 'a.dono_arquivo = u.usuario_id', array('u.nome'=>'u.nome'));

           $stmt = $select->query();
           $result = $stmt->fetchAll();
           return $result;

       }catch(Exception $e){
           echo $e->getMessage();
           //fsd
       }
    }

}