<?php

/*
 * This file is a service provider for the Silex framework of the Respect/Relational Project.
 *
 * @author Willian C. Carminato <williancarminato@gmail.com>
 *
 */

namespace Carminato\Silex\Provider\Respect;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Respect\Relational\Mapper;

/**
 * RespectRelationalServiceProvider
 */
class RespectRelationalServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app)
    {
        $app['respect.pdo.all'] = $app->share(function ($app) {
            if (empty($app['respect.pdo.instances'])) {
                throw new \LengthException("No \PDO instance found", 666);
            }

            return $app['respect.pdo.instances'];
        });

        $app['respect.mapper'] = $app->share(function ($app) {
            $dbs = $app['respect.pdo.all'];

            $defaultDb = array_shift($dbs);

            return new Mapper($defaultDb);
        });

        $app['respect.mappers'] = $app->share(function ($app) {
            $dbs = $app['respect.pdo.all'];

            $mappers = new \Pimple();
            foreach ($dbs as $name => $pdoDb) {
                $mappers[$name] = $mappers->share(function ($mappers) use ($pdoDb) {
                    return new Mapper($pdoDb);
                });
            }

            return $mappers;
        });

    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function boot(Application $app)
    {

    }
}