<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE
 * @class NoCheatPEPlugin
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use TruDan\NoCheatPE\listeners\PlayerListener;
use TruDan\NoCheatPE\tasks\TickTask;

class NoCheatPEPlugin extends PluginBase {

	/**
	 * @var NoCheatPEPlugin
	 */
	private static $instance;

	/**
	 * @var PlayerListener
	 */
	private $playerListener;

	/**
	 * @var TickTask
	 */
	private $tickTask;

	/**
	 * @var NoCheatPlayer[]
	 */
	private $players = [];

	/**
	 * @return NoCheatPEPlugin
	 */
	public static function getInstance() {
		return self::$instance;
	}

	public function onEnable() {
		self::$instance = $this;

		// Load/save default config

		// Register listeners
		$this->playerListener = new PlayerListener($this);
		$this->getServer()->getPluginManager()->registerEvents($this->playerListener, $this);

		// Register Tasks
		$this->tickTask = new TickTask($this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask($this->tickTask, 1);


	}

	public function onDisable() {

		// Save config?



	}

	/**
	 * @param Player $player
	 * @return NoCheatPlayer
	 */
	public function addCheatPlayer(Player $player) {
		if(!isset($this->players[$player->getUniqueId()])) {
			$cp = new NoCheatPlayer($player);
			$this->players[$player->getUniqueId()] = $cp;
			return $cp;
		}
		return $this->players[$player->getUniqueId()];
	}

	/**
	 * @param Player $player
	 * @return NoCheatPlayer|null
	 */
	public function getCheatPlayer(Player $player) {
		if(isset($this->players[$player->getUniqueId()])) {
			return $this->players[$player->getUniqueId()];
		}

		return null;
	}

	/**
	 * @return NoCheatPlayer[]
	 */
	public function getCheatPlayers() {
		return $this->players;
	}

	/**
	 * @param Player $player
	 */
	public function removeCheatPlayer(Player $player) {
		unset($this->players[$player->getUniqueId()]);
	}

}