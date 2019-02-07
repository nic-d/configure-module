<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:16
 */

namespace Nybbl\ConfigureModule\Service;

use Nybbl\ConfigureModule\Entity\SettingsInterface;

/**
 * Interface SettingsServiceInterface
 * @package Nybbl\ConfigureModule\Service
 */
interface SettingsServiceInterface
{
    /**
     * @return SettingsInterface
     */
    public function get(): SettingsInterface;
}