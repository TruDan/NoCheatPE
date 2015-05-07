<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE\hooks
 * @class DetectionHook
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE\hooks;


use pocketmine\Server;
use TruDan\NoCheatPE\events\PlayerHackEvent;
use TruDan\NoCheatPE\NoCheatPlayer;

abstract class DetectionHook {

	/**
	 * @var NoCheatPlayer
	 */
	private $player;

	/**
	 * @param NoCheatPlayer $player
	 */
	public function __construct(NoCheatPlayer $player) {
		$this->player = $player;
	}

	/**
	 * @return NoCheatPlayer
	 */
	public function getCheatPlayer() {
		return $this->player;
	}

	/**
	 * Trigger a Hack event.
	 *
	 * @param int $cheatType A constant from CheatType class.
	 * @param int $severity A value that describes how severe this hack is. 0-10+
	 */
	public function triggerDetection($cheatType, $severity) {
		if($severity <= 0) {
			// This shouldn't happen, but in-case of bad plugins that have their own hooks!
			return;
		}

		$ev = new PlayerHackEvent($this->getPlayer(), $cheatType, $severity);
		Server::getInstance()->getPluginManager()->callEvent($ev);
	}

	/**
	 * @return \pocketmine\Player
	 */
	public function getPlayer() {
		return $this->getCheatPlayer()->getPlayer(); // I know, it's horrible.
	}

	/**
	 * Used when creating the hook, this can be used for registering own events
	 */
	public function onInit() {
	}

	/**
	 * Called every game tick, used for more complicated anti-hack checks
	 *
	 * @param $currentTicks
	 */
	public function onTick($currentTicks) {
	}

}