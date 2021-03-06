<?php

namespace AshleyDawson\DoctrineFlysystemBundle\EventListener;

use AshleyDawson\DoctrineFlysystemBundle\ORM\Mapping\StorableFieldMapperInterface;
use AshleyDawson\DoctrineFlysystemBundle\Storage\StorageHandlerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * Class StorableEventSubscriber
 *
 * @package AshleyDawson\DoctrineFlysystemBundle\EventListener
 */
class StorableEventSubscriber implements EventSubscriber
{
    /**
     * @var StorableFieldMapperInterface
     */
    private $_storableFieldMapper;

    /**
     * @var StorageHandlerInterface
     */
    private $_storageHandler;

    /**
     * Constructor
     *
     * @param StorableFieldMapperInterface $storableFieldMapper
     * @param StorageHandlerInterface $storageHandler
     */
    public function __construct(StorableFieldMapperInterface $storableFieldMapper,
                                StorageHandlerInterface $storageHandler)
    {
        $this->_storableFieldMapper = $storableFieldMapper;
        $this->_storageHandler = $storageHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
        ];
    }

    /**
     * loadClassMetadata event handler
     *
     * @param LoadClassMetadataEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /** @var \Doctrine\ORM\Mapping\ClassMetadataInfo $classMetadata */
        $classMetadata = $args->getClassMetadata();

        if ($this->_storageHandler->isEntitySupported($classMetadata->getName())) {
            $this->_storableFieldMapper->mapFields($classMetadata);
        }
    }

    /**
     * prePersist event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->_storageHandler->store($args->getEntity());
    }

    /**
     * prePersist event handler
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->_storageHandler->store($args->getEntity());
    }

    /**
     * preRemove event handler
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->_storageHandler->delete($args->getEntity());
    }
}
