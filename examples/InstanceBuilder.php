<?php

require_once __DIR__ . '/../src/autoloader.php';

use PHPClassic\InstanceBuilder;

$properties = array(
    'user' => 'admin',
    'age' => 24,
    'allowed' => true,
    'data' => array('country' => 'arg'),
    'main' => 0.0005
);

$crazyClass = InstanceBuilder::build('CrazyClass', $properties);

$singleClass = InstanceBuilder::build('SingleClass');

$namespaceClass = InstanceBuilder::build('NamespaceClass', $properties, 'Core\Space');
?>


<style>pre {background:#eee;padding:5px;max-width:50em}</style>
<h4>Class generation on the fly</h4>


<h5>InstanceBuilder::build(&#39;SingleClass&#39;);</h5>
<pre><?php print_r($singleClass); ?></pre>


<h5>InstanceBuilder::build(&#39;CrazyClass&#39;, $properties);</h5>
<pre><?php print_r($crazyClass); ?></pre>


<h5>InstanceBuilder::build(&#39;NamespaceClass&#39;, $properties, (&#39;Core\Space&#39;);</h5>
<pre><?php print_r($namespaceClass); ?></pre>
