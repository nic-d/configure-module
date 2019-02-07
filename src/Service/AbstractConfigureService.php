<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:31
 */

namespace Configure\Service;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractConfigureService
 * @package Configure\Service
 */
abstract class AbstractConfigureService implements ConfigureServiceInterface
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var SchemaTool $schemaTool */
    private $schemaTool;

    /** @var array $entities */
    private $entities = [];

    /** @var array $entityMetaData */
    private $entityMetaData = [];

    /**
     * AbstractConfigureService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->initSchemaTool();
    }

    /**
     * @param array $entities
     * @return void
     */
    public function init(array $entities = [])
    {
        $this->entities = $entities;
        $this->initEntityMetaData();
    }

    /**
     * @return bool
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function install(): bool
    {
        $this->schemaTool->createSchema($this->entityMetaData);
        return true;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $this->schemaTool->updateSchema($this->entityMetaData, true);
        return true;
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        $this->schemaTool->dropSchema($this->entityMetaData);
        return true;
    }

    /**
     * @return SchemaTool
     */
    private function initSchemaTool(): SchemaTool
    {
        $this->schemaTool = new SchemaTool($this->entityManager);
        return $this->schemaTool;
    }

    /**
     * Gets class metadata for each Entity...
     * @return void
     */
    private function initEntityMetaData()
    {
        $entities = [];

        foreach ($this->entities as $entity) {
            $entities[] = $this->entityManager->getClassMetadata($entity);
        }

        $this->entityMetaData = $entities;
    }
}