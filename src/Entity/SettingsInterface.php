<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:18
 */

namespace Configure\Entity;

/**
 * Interface SettingsInterface
 * @package Configure\Entity
 */
interface SettingsInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * @param \DateTime $updatedAt
     * @return void
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}