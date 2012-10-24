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
        $table = new Application_Model_DbTable_Arquivo;
        $table->insert($data['arquivos']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "arquivo";
        $deletado = true;
        $where = $db->quoteInto('arquivo_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);
    }

    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Arquivo;
        $where = $table->getAdapter()->quoteInto('arquivo_id = ?',$id);

        $table->update($data['arquivos'], $where);
    }

    public function getLastInsertedId(){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(arquivo_id) FROM arquivo");
        return (int)$result+1;
    }

    public function existePasta($projetoid, $tarefaid)
    {
        $pathprojeto = 'files/arquivos/projeto-'.$projetoid;
        $pathtarefa=$pathprojeto.'/tarefa-'.$tarefaid;

        if(file_exists($pathprojeto))
        {
           // buscar pasta tarefas
            if(file_exists($pathtarefa))
            {
                return $pathtarefa;
            }else
            {
                mkdir($pathtarefa, 0777);
                return $pathtarefa;
            }

        }else{
            // criar pasta projeto
            mkdir(''.$pathprojeto, 0777);
            mkdir($pathtarefa, 0777);
            return $pathtarefa;
        }
    }

    public function editarArquivo($pasta,$nome_arquivo,$data)
    {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->addFilter('Rename', $pasta);

        try {
            // upload received file(s)
            $upload->receive();
            //pegando o tamanho do arquivo e inserindo na variável data
            $tamanho = $upload->getFileInfo('nome_arquivo');
            $data['arquivos']['tamanho']=$tamanho['nome_arquivo']['size'];
            print_r($tamanho);
            exit;


        } catch (Zend_File_Transfer_Exception $e) {
            $e->getMessage();
        }


        //pegando o formato do arquivo
        $file = $upload->getFileName('nome_arquivo');


        $formato = explode(".",$file);
        $indice = count($formato)-1;

        //renomeando o arquivo
        $fullFilePathFile = $pasta.'/'.$nome_arquivo.'.'.$formato[$indice];
        $filterFileRename = new Zend_Filter_File_Rename(array('target' => $fullFilePathFile, 'overwrite' => true));
        $filterFileRename -> filter($file);



    }

    public function selectAll()
    {
       try{
           $db = Zend_Db_Table::getDefaultAdapter();

           $select = $db->select()
               ->from(array('a' => 'arquivo'), array('a.arquivo_id'=>'a.arquivo_id', 'a.nome_arquivo'=>'a.nome_arquivo', 'a.versao'=>'a.versao', 'a.tamanho'=>'a.tamanho', 'a.data_arquivo'=>'a.data_arquivo', 'a.descricao_arquivo'=>'a.descricao_arquivo', 'a.nome_real'=>'a.nome_real'))
               ->where('a.deletado = ?', false)
               ->joinLeft(array('t' => 'tarefa'), 'a.tarefa_id = t.tarefa_id', array('t.nome'=>'t.nome'))
               ->joinLeft(array('ta' => 'tipo_arquivo'), 'a.tipo_arquivo_id = ta.tipo_arquivo_id', array('ta.nome_tipo'=>'ta.nome_tipo'))
               ->joinLeft(array('u' => 'usuario'), 'a.dono_arquivo = u.usuario_id', array('u.nome'=>'u.nome'));

           $stmt = $select->query();
           $result = $stmt->fetchAll();
           return $result;

       }catch(Exception $e){
           echo $e->getMessage();
       }
    }

}