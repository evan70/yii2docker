<?php

namespace Deployer;

/**
 * Tasks
 *
 * NOTE:
 *  To run 'sudo' commands, you need to put this line into the file /etc/sudoers.d/USERNAME
 *  USERNAME ALL=NOPASSWD:ALL
 *
 *  Or you can enable TTY for ask password
 *  run(..., ['tty' => true])
 */
task(
    'supervisor:stop',
    function () {
        run('sudo supervisorctl stop all');
    }
)->desc(
    'Stop supervisor service'
);

task(
    'supervisor:start',
    function () {
        run('sudo supervisorctl start all');
    }
)->desc(
    'Start supervisor service'
);

task(
    'npm:install',
    function () {
        within(
            '{{release_path}}',
            function () {
                run('npm install');
            }
        );
    }
)->desc(
    'Install NPM packages'
);

task(
    'npm:build',
    function () {
        within(
            '{{release_path}}',
            function () {
                run('npm run production');
            }
        );
    }
)->desc(
    'Build NPM assets'
);

task(
    'yii:migrate',
    function () {
        run('{{bin/php}} {{release_path}}/yii migrate --interactive=0');
    }
)->desc(
    'Apply database migrations'
);

task(
    'deploy:env',
    function () {
        upload('.env.example', '{{deploy_path}}/shared/.env');
    }
)->desc(
    'Deploy ENV production config'
);

task(
    'deploy:symlink',
    function () {
        // remove older public directory
        run('rm {{public_path}} -rf');

        // create custom symlink
        within(
            '{{deploy_path}}',
            function () {
                run("{{bin/symlink}} {{release_path}} {{public_path}}");
                run("rm release"); // Remove release link.
            }
        );
    }
)->desc(
    'Creating symlink to release'
);