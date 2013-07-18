<?php
/**
 * Created by PhpStorm.
 * @author: pomaxa none <pomaxa@gmail.com>
 * @date: 7/18/13
 */


require('vendor/autoload.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => 'templates_c/twig',
    'autoescape' => false,
    'auto_reload' => false,
));

$faker = Faker\Factory::create();


$data = array();
for($i = 0; $i<=7; $i++) {
    $data['var'.$i] = $faker->text;
}

echo "<h1>Twig</h1>";

$firstTime = 0;
$try = array();
for($i=0; $i<=10; $i++) {
    $start = microtime(true);
    $template = $twig->loadTemplate('twig/simple.html.twig');
    $template->render($data);
    $time = microtime(true)-$start;

    if($i == 0) {
        $firstTime = $time;
    } else {
        $try[] = $time;
    }
}

foreach ($try as $index => $pass) {
    printf('<br>Pass %d time %.8f', $index, $pass);
}

printf('<br>First run: %.8f', $firstTime);
printf('<br>Average display: %.8f', array_sum($try) / count($try));

echo "<h1>Smarty</h1>";

$smarty = new Smarty();
$smarty->compile_check = false;

for($i=0; $i<=10; $i++) {
    $start = microtime(true);
    $smarty->assign($data);
    $smarty->fetch('smarty/simple.html.twig');
    $time = microtime(true)-$start;

    if($i == 0) {
        $firstTime = $time;
    } else {
        $try[] = $time;
    }
}

foreach ($try as $index => $pass) {
    printf('<br>Pass %d time %.8f', $index, $pass);
}

printf('<br>First run: %.8f', $firstTime);
printf('<br>Average display: %.8f', array_sum($try) / count($try));