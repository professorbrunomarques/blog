<?php
namespace Blog\helper;

use \Blog\helper\Check;

class Upload 
{
    private $File;
    private $Max_file_size;
    private $path;

    private static $Dados;
    private static $Data;
    private static $Format;
    
    public function image($file, $filename = null){
        $this->File = $file;
        $this->Max_file_size = pow(1024, 2)*2; // Tamanho máximo para upload 2Mb 
        $this->path = $_SERVER["DOCUMENT_ROOT"];
        
        //Validando o tamanho do arquivo
        if($this->File["size"] > $this->Max_file_size):
            throw new \Exception("O tamanho do arquivo é maior que 2Mb");
        endif;
        
        //Validando o tipo do arquivo
        $file_type = array("image/gif", "image/png", "image/jpeg", "image/bmp");
        if(!in_array($this->File["type"], $file_type)){
            throw new \Exception("O formato do arquivo (".$this->File["type"].") não é suportado");
        }

        //Criando o diretório de acordo com a data
        $dir = $this->makeDir();

        //Gerando o nome do arquivo caso não tenha sido informado
        $ext = substr($this->File["name"],strpos($this->File["name"],"."),4);
        if(!$filename){
            $file_name = substr($this->File["name"], 0,strpos($this->File["name"],"."));
            $file_name = Check::Name($file_name);
            $new_file = $file_name.$ext;
        }else{
            $new_file = $filename.$ext;
        }

        if(move_uploaded_file($this->File["tmp_name"],$this->path.$dir.$new_file)):
            return $dir.$new_file;
        else:
            throw new \Exception("Erro ao enviar o arquivo $new_file");
        endif;
    }

    private function makeDir(){
        $data = explode("/", date("d/m/Y"));
        if(!is_dir($this->path.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$data[2].DIRECTORY_SEPARATOR.$data[1].DIRECTORY_SEPARATOR.$data[0])):
            mkdir($this->path.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$data[2].DIRECTORY_SEPARATOR.$data[1].DIRECTORY_SEPARATOR.$data[0], 0777, true);
        endif;
        return "/uploads/".$data[2]."/".$data[1]."/".$data[0]."/";
    }

}
