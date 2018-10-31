<?php
    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public function Words(string $texto, int $limite, $ponteiro = null) 
    {
        self::$Data = strip_tags($texto);
        self::$Format = (int) $limite;

        $arrWords = explode(" ", self::$Data);
        $numWords = count($arrWords);
        $newWord = implode(" ", array_slice($arrWords, 0, self::$Format));

        if (!empty($ponteiro)) {
            $newWord .= $ponteiro;
        }

        return $newWord;
    }