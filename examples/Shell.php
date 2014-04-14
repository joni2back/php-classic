<?php

require_once __DIR__ . '/../src/autoloader.php';

$shell = new \PHPClassic\Shell;

$command = 'ls';
$params = array(__DIR__, '-la');

$shell->execute($command, $params)
?>

<style>pre {background:#eee;padding:5px;max-width:50em}</style>
<h4>Command response</h4>

<h5>Command</h5>
<pre><?php echo $command . ' ' . implode(" ", $params); ?></pre>

<h5>Output</h5>
<pre><?php echo $shell->getOutput(); ?></pre>

<h5>Exit Status</h5>
<pre><?php echo $shell->getStatus(); ?></pre>

<h5>Has errors</h5>
<pre><?php echo !$shell->isSuccessful() ? 'true' : 'false'; ?></pre>

<h5>Total lines</h5>
<pre><?php echo $shell->getTotalLines(); ?></pre>

<h5>Output excluding self and parent dir [$shell->grep('/\.$/', true)]</h5>
<pre><?php echo $shell->grep('/\.$/', true)->getOutput(); ?></pre>
