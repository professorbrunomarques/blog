<?php
namespace Blog\helper;

use Check;

class Upload 
{
    private $File;
    private $Max_file_size;

    private static $Dados;
    private static $Data;
    private static $Format;
    
    public function image($file){
        $this->File = $file;
        $this->Max_file_size = pow(1024, 2)*2; // Tamanho máximo para upload 2Mb 
        
        //Validando o tamanho do arquivo
        if($this->File["size"] > $this->Max_file_size):
            echo "O tamanho do arquivo é maior que 2Mb";
            return false; 
        endif;
        //Validando o tipo do arquivo
        $file_type = array("image/gif", "image/png", "image/jpeg", "image/bmp");
        if(!in_array($this->File["type"], $file_type)){
            echo "O formato do arquivo (".$this->File["type"].") não é suportado";
            return false;
        }
        $dir = $this->makeDir();
        $ext = substr($this->File["name"],strpos($this->File["name"],"."),4);
        $file_name = substr($this->File["name"], 0,strpos($this->File["name"],"."));
        $file_name = \Blog\helper\Check::Name($file_name);
        $new_file = $file_name.$ext;

        if(move_uploaded_file($this->File["tmp_name"],$dir.$new_file)):
            echo "O arquivo $new_file, foi enviado com sucesso para a pasta $dir";
            return "true";
        else:
            echo "Erro ao enviar o arquivo $new_file";
            return "false";
        endif;
    }

    private function makeDir(){
        $path = $_SERVER["DOCUMENT_ROOT"]."/blog";
        $data = explode("/", date("d/m/Y"));
        if(!is_dir($path."/uploads")):
            mkdir($path."/uploads", 0777, true);
        endif;
        if(!is_dir($path."/uploads/".$data[2])):
            mkdir($path."/uploads/".$data[2], 0777, true);
            if(!is_dir($path."/uploads/".$data[2]."/".$data[1])):
                mkdir($path."/uploads/".$data[2]."/".$data[1], 0777, true);
                if(!is_dir($path."/uploads/".$data[2]."/".$data[1]."/".$data[0])):
                    mkdir($path."/uploads/".$data[2]."/".$data[1]."/".$data[0], 0777, true);
                endif;
            endif;
        endif;
        return $path."/uploads/".$data[2]."/".$data[1]."/".$data[0]."/";
    }

}
