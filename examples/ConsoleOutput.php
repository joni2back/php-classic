<?php

require_once __DIR__ . '/../src/autoloader.php';

$output = new PHPClassic\ConsoleOutput;

$output->writeTitle('ConsoleOuput example');
$output->writeLn();

foreach (range(0, 3) as $ver) {
    foreach (range(0, 3) as $hor) {
        $char = '0';
        $output
            ->setColor('black', null, 'bold')->write($char)
            ->setColor('red', null, 'bold')->write($char)
            ->setColor('green', null, 'bold')->write($char)
            ->setColor('yellow', null, 'bold')->write($char)
            ->setColor('blue', null, 'bold')->write($char)
            ->setColor('magenta', null, 'bold')->write($char)
            ->setColor('cyan', null, 'bold')->write($char)
            ->setColor('white', null, 'bold')->write($char)
        ->restoreColor();
    }
    $output->writeLn();
}
$output->writeLn();

$output
    ->setColor('red', null, 'bold')->write('This ')
    ->setColor('green', null, 'bold')->write('is ')
    ->setColor('blue', null, 'bold')->write('a ')
    ->setColor('yellow', null, 'bold')->write('PHPClassic ')
    ->setColor('cyan', null, 'bold')->writeLn('class')
->restoreColor();

$items = array('red', 'green', 'blue', 'yellow', 'cyan');
foreach (range(0, 10) as $num) {
    $color = $items[array_rand($items)];
    $output->setColor($color, null, 'bold')->writeLn(str_repeat('*', $num));
}