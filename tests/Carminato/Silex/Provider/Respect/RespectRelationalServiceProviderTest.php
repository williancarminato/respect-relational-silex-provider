<?php

namespace Carminato\Silex\Provider\Respect;

use Silex\Application;

class RespectRelationalServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \LengthException
     * @expectedExceptionMessage No \PDO instance found
     */
    public function testMapperWithoutPdoInstanceMustFail()
    {
        $app = new Application();
        $app->register(new RespectRelationalServiceProvider());

        $app['respect.pdo.all'];
    }

    public function testSingleMapperInstance()
    {
        $app = new Application();
        $app->register(new RespectRelationalServiceProvider(), array(
                'respect.pdo.instances' => array(new \PDO('sqlite::memory:'))
            )
        );

        $this->assertCount(1, $app['respect.pdo.instances']);
        $this->assertInstanceOf('\PDO', $app['respect.pdo.instances'][0]);
        $this->assertInstanceOf('Respect\Relational\Mapper', $app['respect.mapper']);
    }

    public function testMultipleMapperInstances()
    {
        $app = new Application();
        $app->register(new RespectRelationalServiceProvider(), array(
                'respect.pdo.instances' => array(
                    'test1' => new \PDO('sqlite::memory:'),
                    'test2' => new \PDO('sqlite::memory:')
                )
            )
        );

        $this->assertCount(2, $app['respect.pdo.instances']);

        $this->assertInstanceOf('\PDO', $app['respect.pdo.instances']['test1']);
        $this->assertInstanceOf('Respect\Relational\Mapper', $app['respect.mappers']['test1']);

        $this->assertInstanceOf('\PDO', $app['respect.pdo.instances']['test2']);
        $this->assertInstanceOf('Respect\Relational\Mapper', $app['respect.mappers']['test2']);
    }
}