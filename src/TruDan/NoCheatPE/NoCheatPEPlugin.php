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
use TruDan\NoCheatPE\hooks\AntiSpeedDetection;
use TruDan\NoCheatPE\hooks\DetectionHook;
use TruDan\NoCheatPE\listeners\PlayerListener;
use TruDan\NoCheatPE\tasks\TickTask;

class NoCheatPEPlugin extends PluginBase {

	/**
	 * @var NoCheatPEPlugin
	 */
	private static $instance;

	/**
	 * @var DetectionHook[]
	 */
	private static $hooks = [];

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

		// Load default hooks
		self::registerHook(AntiSpeedDetection::class);

	}

	public function onDisable() {
		// Save config?


	}

	/**
	 * Register a Detection hook with NoCheatPE.
	 *
	 * Returns true on success.
	 *
	 * @param $hookClass
	 * @return bool
	 */
	public static function registerHook($hookClass) {
		$class = new \ReflectionClass($hookClass);

		if(is_a($hookClass, DetectionHook::class) && !$class->isAbstract()) {
			preg_match("/([^\\\]+\\\)*([^\\\]+)$/", $hookClass, $matches);
			$className = end($matches);

			self::$hooks[strtolower($className)] = $hookClass;

			self::getInstance()->getLogger()->info("Registered Detection Hook: " . $className);
			return true;
		}
		return false;
	}

	/**
	 * @return DetectionHook[]
	 */
	public static function getHooks() {
		return self::$hooks;
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