<?php

namespace AshleyDawson\DoctrineFlysystemBundle\Tests\Storage;

use AshleyDawson\DoctrineFlysystemBundle\ORM\StorableTrait;
use AshleyDawson\DoctrineFlysystemBundle\Storage\StorageHandler;

/**
 * Class StorableTraitImpl
 *
 * @package AshleyDawson\DoctrineFlysystemBundle\Tests\ORM
 */
class StorableTraitImpl
{
    use StorableTrait;

    public function getFilesystemId()
    {
        return 'dummy_filesystem_id';
    }
}

/**
 * Class DummyImpl
 *
 * @package AshleyDawson\DoctrineFlysystemBundle\Tests\ORM
 */
class DummyImpl
{
    public function getFilesystemId()
    {
        return 'dummy_filesystem_id';
    }
}

/**
 * Class StorageHandlerTest
 *
 * @package AshleyDawson\DoctrineFlysystemBundle\Tests\Storage
 */
class StorageHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StorageHandler
     */
    private $_storageHandler;

    protected function setUp()
    {
        $this->_storageHandler = new StorageHandler();
    }

    public function testIsEntityClassSupported()
    {
        $this->assertTrue(
            $this->_storageHandler->isEntitySupported('AshleyDawson\DoctrineFlysystemBundle\Tests\Storage\StorableTraitImpl')
        );
    }

    public function testIsEntityClassNotSupported()
    {
        $this->assertNotTrue(
            $this->_storageHandler->isEntitySupported('AshleyDawson\DoctrineFlysystemBundle\Tests\Storage\DummyImpl')
        );
    }

    public function testIsEntityClassSupportedClassNotFound()
    {
        $this->setExpectedException('AshleyDawson\DoctrineFlysystemBundle\Exception\ClassDoesNotExistException');

        $this->assertNotTrue(
            $this->_storageHandler->isEntitySupported('AshleyDawson\DoctrineFlysystemBundle\Tests\Storage\FooBarNotHere')
        );
    }
}