<?php

function enleverAccents($str) {
    // On crée un tableau de correspondances pour enlever les accents
    $accents = array('à' => 'a', 'á' => 'a', 'ä' => 'a', 'â' => 'a', 'ã' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ë' => 'e', 'ê' => 'e', 'ì' => 'i', 'í' => 'i', 'ï' => 'i', 'î' => 'i', 'ò' => 'o', 'ó' => 'o', 'ö' => 'o', 'ô' => 'o', 'õ' => 'o', 'ø' => 'o', 'œ' => 'oe', 'ù' => 'u', 'ú' => 'u', 'ü' => 'u', 'û' => 'u', 'ý' => 'y', 'ÿ' => 'y', 'ñ' => 'n', 'À' => 'A', 'Á' => 'A', 'Ä' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ë' => 'E', 'Ê' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Ò' => 'O', 'Ó' => 'O', 'Ö' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ø' => 'O', 'Œ' => 'OE', 'Ù' => 'U', 'Ú' => 'U', 'Ü' => 'U', 'Û' => 'U', 'Ý' => 'Y');

    // Remplace les caractères accentués par leur version sans accent
    return strtr($str, $accents);
}