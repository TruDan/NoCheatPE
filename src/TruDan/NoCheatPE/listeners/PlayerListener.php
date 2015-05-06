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
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerQuitEvent;
use TruDan\NoCheatPE\NoCheatPEPlugin;

class PlayerListener implements Listener {

	/**
	 * @var NoCheatPEPlugin
	 */
	private $plugin;

	/**
	 * @param NoCheatPEPlugin $plugin
	 */
	public function __construct(NoCheatPEPlugin $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @param PlayerJoinEvent $event
	 */
	public function onPlayerJoin(PlayerJoinEvent $event) {
		$this->getPlugin()->addCheatPlayer($event->getPlayer());
	}

	/**
	 * @return NoCheatPEPlugin
	 */
	private function getPlugin() {
		return $this->plugin;
	}

	/**
	 * @param PlayerQuitEvent $event
	 */
	public function onPlayerQuit(PlayerQuitEvent $event) {
		$this->getPlugin()->removeCheatPlayer($event->getPlayer());
	}

	/**
	 * @param PlayerKickEvent $event
	 */
	public function onPlayerKick(PlayerKickEvent $event) {
		$this->getPlugin()->removeCheatPlayer($event->getPlayer());
	}


}