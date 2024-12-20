<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

$env = 'test';

passthru(
    sprintf(
        'php bin/console doctrine:database:drop --if-exists --force --env=%s',
        $env
    )
);

passthru(
    sprintf(
        'php bin/console doctrine:database:create --if-not-exists --env=%s',
        $env
    )
);

passthru(
    sprintf(
        'php bin/console doctrine:schema:create -q --env=%s',
        $env
    )
);
