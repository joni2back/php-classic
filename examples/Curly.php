<?php

require_once __DIR__ . '/../src/autoloader.php';

$curly = new \PHPClassic\Curly;

$url = 'http://api.stackoverflow.com/1.0/questions';
$headers = array(
    'Accept: application/json',
    'Accept-Encoding: gzip',
);

$curly->setUrl($url);
$curly->addHeaders($headers);
$curly->addGetParams(array('vendor' => 'curly'));
$curly->execute();


$json = gzdecode($curly->getResponse());
$obj = json_decode($json);

$articles = array();
if (isset($obj->questions) && is_array($obj->questions)) {
    foreach ($obj->questions as $question) {
        if (isset($question->title)) {
            $articles[] = substr($question->title, 0, 50) . "...";
        }
    }
    $articles = array_slice($articles, 0, 5);
}

?>

<style>pre {background:#eee;padding:5px;max-width:50em; margin-top:-20px}</style>
<h4>Latest questions on StackOverflow</h4>

<h5>Request Uri</h5>
<pre><?php print_r($url); ?></pre>

<h5>Request Headers</h5>
<pre><?php print_r($headers); ?></pre>

<h5>Response Headers</h5>
<pre><?php print_r($curly->getResponseHeaders()); ?></pre>

<h5>Response Content</h5>
<pre><?php print_r($articles); ?></pre>
