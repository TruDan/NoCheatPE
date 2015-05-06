<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE\listeners
 * @class PlayerListener
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE\listeners;


use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;

class PlayerListener implements Listener {

	/**
	 * Checks:
	 *  - Too many packets?
	 *
	 * @param DataPacketReceiveEvent $event
	 */
	public function onDataPacketReceive(DataPacketReceiveEvent $event) {

	}


}