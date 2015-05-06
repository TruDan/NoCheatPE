<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE\events
 * @class PlayerHackEvent
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE\events;


use pocketmine\event\Event;
use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;

class PlayerHackEvent extends PlayerEvent {

	public static $handlerList;

	/**
	 * @var int
	 */
	private $hackType;

	/**
	 * @var int
	 */
	private $severity = 1;

	/**
	 * @param Player $player
	 * @param int $hackType
	 * @param int $severity
	 */
	public function __construct(Player $player, $hackType, $severity) {
		$this->player = $player;
		$this->hackType = $hackType;
		$this->severity = $severity;
	}

	public function getHackType() {
		return $this->hackType;
	}

	public function getSeverity() {
		return $this->severity;
	}


}