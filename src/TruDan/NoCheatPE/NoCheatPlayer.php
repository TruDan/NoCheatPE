<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE
 * @class NoCheatPlayer
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE;


use pocketmine\Player;
use TruDan\NoCheatPE\hooks\DetectionHook;

class NoCheatPlayer {

	/**
	 * @var Player
	 */
	private $player;

	/**
	 * @var DetectionHook[]
	 */
	private $hooks = [];

	/**
	 * @param Player $player
	 */
	public function __construct(Player $player) {
		$this->player = $player;

		// Initialise the hooks
		$hooks = NoCheatPEPlugin::getHooks();
		if(count($hooks) > 0) {
			foreach($hooks as $hookClass) {
				/** @var DetectionHook $hook */
				$hook = new $hookClass($this);
				$this->hooks[] = $hook;
			}
		}
	}

	/**
	 * @return Player
	 */
	public function getPlayer() {
		return $this->player;
	}

	/**
	 * @param $currentTicks
	 */
	public function onTick($currentTicks) {
		// Do stuff!
		foreach($this->hooks as $hook) {
			$hook->onTick($currentTicks);
		}
	}

}