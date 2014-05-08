<?php
include_once('simple_html_dom.php');

function scraping_letras($url_base, $matriz) {

    foreach ($matriz as $key => $value) {
        $html = file_get_html($url_base.$value);

        $letra[$key] = $html->find('article[id="div_letra"]', 0)->plaintext;

        $html->clear();
        unset($html);
    }

    echo '<pre>';
    print_r($letra);

    return true;
}

function scraping_links($url) {
    // create HTML DOM
    $html = file_get_html($url);

    $links = array();

    foreach($html->find('div[class="cnt_listas"]') as $div) {

        foreach ($div->find('a') as $key => $value) {
            $links[$key] = $value->getAttribute('href');
        }

    }

    // clean up memory
    $html->clear();
    unset($html);

    return $links;
}

$url_base = 'http://letras.mus.br/';

$url_artista = 'racionais-mcs';

$links = scraping_links($url_base . $url_artista);

$letras = scraping_letras($url_base, $links);

// echo '<pre>';
// print_r($links);

?>