<?php
/**
 * Created by PhpStorm.
 * User: Nic
 * Date: 07/02/2019
 * Time: 12:16
 */

namespace Nybbl\ConfigureModule\Service;

/**
 * Interface SettingsServiceInterface
 * @package Nybbl\ConfigureModule\Service
 */
interface SettingsServiceInterface
{
    public function get();

    public function set();

    public function update();

    public function remove();
}