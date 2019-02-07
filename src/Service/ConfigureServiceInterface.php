<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:02
 */

namespace Configure\Service;

/**
 * Interface ConfigureServiceInterface
 * @package Configure\Service
 */
interface ConfigureServiceInterface
{
    /**
     * @param array $entities
     * @return void
     */
    public function init(array $entities = []);

    /**
     * @return bool
     */
    public function install(): bool;

    /**
     * @return bool
     */
    public function update(): bool;

    /**
     * @return bool
     */
    public function uninstall(): bool;
}