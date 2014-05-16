<?php
include_once('simple_html_dom.php');

function index_page($work) {
    $index = array();
    $texto = '';
    
    foreach ($work as $key => $value) {
        $texto .= $value;
    }
      
    $work = trim($texto);
    $work = explode(' ', $work);
    natcasesort($work);
    foreach ($work AS $key) {
        $key = trim($key);
        $key = strtolower($key);
        $junk = preg_match('/[^a-zA-Z]/', $key);
        if($junk == 1) {
            $key = '';
        }
        if (!$index[$key]) $index[$key] = 0;
        $index[$key]++;
    }


    return($index);
}

function scraping_letras($url_base, $matriz) {

    foreach ($matriz as $key => $value) {
        $html = file_get_html($url_base.$value);

        $letra[$key] = $html->find('article[id="div_letra"]', 0)->plaintext;

        $html->clear();
        unset($html);
    }

    $indexado = index_page($letra);

    return $indexado;
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

echo '<pre>';
print_r($letras);
echo count($letras);

// echo '<pre>';
// print_r($links);

?>