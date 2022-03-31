<?php

if (!isset($_GET['key']) || $_GET['key'] != 'qh8Uep01jBe7hq3HKl2pl83Vd') {
    die;
}

$commands = [
    'cd /var/www/genieping',
    'git pull -q origin master',
    'php ../composer.phar install --no-dev --quiet',
    'php yii migrate --interactive=0',
];

exec(implode(' && ', $commands), $output);
#var_dump($output);