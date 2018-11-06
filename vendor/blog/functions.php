<?php

function Words(string $texto, int $limite, $ponteiro = null) {
    $Data = strip_tags($texto);
    $Format = (int) $limite;

    $arrWords = explode(" ", $Data);
    $numWords = count($arrWords);
    $newWord = implode(" ", array_slice($arrWords, 0, $Format));

    if (!empty($ponteiro)) {
        $newWord .= $ponteiro;
    }

    return $newWord;
}

function datePt_Br($data){
    return strftime('%e de %B de %Y às %H:%M', 
            strtotime($data));
}

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}