<?php

require_once __DIR__ . '/../src/autoloader.php';

if (defined('\PHP_SAPI') && \PHP_SAPI != 'cli') {
    echo 'You must run this in your console: <b>php ' .  __FILE__ . '</b>';
    exit(1);
}

$output = new \PHPClassic\ConsoleOutput;
$input = new \PHPClassic\ConsoleInput($output);

$name = $input->validate('/^[a-z]{2,32}.+$/i', 'Enter a valid name')->prompt('What is your name?');

$output
    ->setColor('green')->write("Hello ")
    ->setColor('green', null, 'bold')->writeLn($name . "\n");


$printLine = $input
    ->validate('/(y|yes|n|no)/i', 'Invalid answer')
    ->prompt('Do you want to print a line? [Y/n]', 'y');
$line = "Ok, line written: " . str_repeat('*', 35) . "\n";
$output->writeLn(preg_match('/^y/i', $printLine) ? $line : null);


$input
    ->validate('/(exit)/i', 'Invalid answer')
    ->prompt('Write "exit" to end this example');