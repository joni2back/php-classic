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


<style>pre {background:#eee;padding:5px;max-width:50em; margin-top:-20px}</style>
<h4>Class generation on the fly</h4>


<h5>InstanceBuilder::build(&#39;SingleClass&#39;);</h5>
<pre><?php print_r($singleClass); ?></pre>


<h5>InstanceBuilder::build(&#39;CrazyClass&#39;, $properties);</h5>
<pre><?php print_r($crazyClass); ?></pre>


<h5>InstanceBuilder::build(&#39;NamespaceClass&#39;, $properties, &#39;Core\Space&#39;);</h5>
<pre><?php print_r($namespaceClass); ?></pre>

<h5>$instance-&gt;user;</h5>
<pre><?php print_r($namespaceClass->getUser()); ?></pre>

<h5>$instance-&gt;getUser();</h5>
<pre><?php print_r($namespaceClass->getUser()); ?></pre>

<h5>$instance-&gt;getAge();</h5>
<pre><?php print_r($namespaceClass->getAge()); ?></pre>

<h5>$instance-&gt;getData();</h5>
<pre><?php print_r($namespaceClass->getData()); ?></pre>

<h5>$instance-&gt;setData($instance-&gt;getData() + array(&#39;lang&#39; =&gt; &#39;es&#39;, &#39;rand&#39; =&gt; rand()));</h5>
<?php $namespaceClass->setData($namespaceClass->getData() + array('lang' => 'es', 'rand' => rand())); ?>
<pre><?php print_r($namespaceClass); ?></pre>
