<?php
namespace Blog;

use Rain\Tpl;
use \Blog\helper\Check;

class Page
{

    private $tpl;
    private $options = [];
    //Valor padrão caso não seja passado $opts
    private $defaults = [
        "header" => true,
        "footer" => true,
        "data" => [],
    ];

    /**
     * Método contrutor que irá criar o Header do Template View.
     * Este médodo
     */
    public function __construct($opts = array(), $tpl_dir = "./views/")
    {
        //Casso seja enviada as opções, será feito o merge do default com o que foi enviado em $opts.
        //Essas $opts são variáveis que serão substituidas no HTML nesse formato {$nome}
        $this->options = array_merge($this->defaults, $opts);
        $config = array(
            "tpl_dir" => $tpl_dir,
            "cache_dir" => "./views-cache/",
            "debug" => false, // set to false to improve the speed
        );

        Tpl::configure($config);
        $this->tpl = new Tpl;
        if (isset($_SESSION["User"])) {
            //Inclusão da sessão do usuário para exibição no template
            $this->options["data"] = $_SESSION["User"];
            //Busca a imagem no gravatar de acordo com o email
            $this->options["data"]["image"] = Check::get_gravatar($this->options["data"]["email"]);
            //Remove o password do template
            unset($this->options["data"]["password"]);
        }
        $this->setData($this->options["data"]);

        //Desenha o template do header.html, que está na pasta views e renderiza na tela.
        if ($this->options["header"] === true) {
            $this->tpl->draw("header");
        }

    }
    private function setData($data = array())
    {
        //faz a atribuição das variáveis
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }
    // Corpo da página
    /**
     * Renderiza o corpo da página
     * @param string $name = Nome do arquivo que será renderizado no corpo da página.
     * @param array $data = Variáveis que serão substituidas.
     * @param bool $returnHTML = Se o retorno será ou não um HTML.
     */
    public function setTpl($name, $data = array(), $returnHTML = false)
    {
        $this->setData($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct()
    {
        //Desenha o template do footer.html, que está na pasta views e renderiza na tela.
        if ($this->options["footer"] === true) {
            $this->tpl->draw("footer");
        }

    }
}
