<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE\tasks
 * @class TickTask
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE\tasks;


use pocketmine\scheduler\PluginTask;
use TruDan\NoCheatPE\NoCheatPEPlugin;

class TickTask extends PluginTask {

	public function onRun($currentTicks) {
		/** @var NoCheatPEPlugin $plugin */
		$plugin = $this->getOwner();

		foreach($plugin->getCheatPlayers() as $cheatPlayer) {
			$cheatPlayer->onTick($currentTicks);
		}
	}

}