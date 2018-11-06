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