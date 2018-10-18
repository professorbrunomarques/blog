<?php

namespace Blog;

class Model
{

    //Vai armazenar os dados do usuário
    private $values = [];

    /** Método mágico que irá passar pelos parâmetros $name e $args a o Metodo que foi chamado
    * gerando os geters ou setters.
    */
    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));

        switch ($method) {
            case 'set':
                $this->values[$fieldName] = $args[0];
                break;
            case 'get':
                return $this->values[$fieldName];
                break;
        }
    }
    /**
     * Esse Método irá buscar todos os campos da tabela e gerar seus metodos gets e setters
     */
    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->{"set".$key}($value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }

}
