<?php
/**
 * NoCheatPE
 *
 * @package TruDan\NoCheatPE\hooks
 * @class AntiSpeedDetection
 *
 * User: Dan
 * Date: 11/02/2015
 * Time: 17:42
 */

namespace TruDan\NoCheatPE\hooks;


use pocketmine\entity\Effect;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use TruDan\NoCheatPE\data\CheatType;

class AntiSpeedDetection extends DetectionHook {

	const WALKING_SPEED = 4.3;

	/**
	 * @var Position
	 */
	private $previousPosition;

	/**
	 * @var Vector3
	 */
	private $previousMotion;

	/**
	 * @var int
	 */
	private $lastCheckTick = 0;

	public function onTick($currentTick) {

		$prev = $this->previousPosition;
		$current = $this->getPlayer()->getPosition();

		if(!($prev instanceof Position)) {
			return;
		}

		if($prev->getLevel() != $current->getLevel()) {
			return;
		}

		$maxDistance = $this->getMaxDistance($currentTick - $this->lastCheckTick);

		// Ignore Y values (in case of jump boosts etc)
		$actualDistance = sqrt(abs(($prev->getX() - $current->getX()) * ($prev->getZ() - $current->getZ())));

		$diff = $maxDistance - $actualDistance;
		if($diff > 0) {
			// I CALL HAX!
			$this->triggerDetection(CheatType::PLAYER_MOVEMENT_EXCESS_SPEED, $diff);
		}

		// Store current variables for the next tick
		$this->previousMotion = $this->getPlayer()->getMotion();
		$this->previousPosition = $this->getPlayer()->getPosition();
		$this->lastCheckTick = $currentTick;
	}

	private function getMaxDistance($tickDifference) {
		// Speed potions?
		$effects = $this->getPlayer()->getEffects();

		$amplifier = 0;

		// Check for speed potions.
		if(!empty($effects)) {
			foreach($effects as $effect) {
				if($effect->getId() == Effect::SPEED) {
					$a = $effect->getAmplifier();

					// In-case there is more than one speed effect on a player, get the max.
					if($a > $amplifier) {
						$amplifier = $a;
					}
				}
			}
		}

		$distance = self::WALKING_SPEED + ($amplifier != 0) ? (self::WALKING_SPEED / (0.2 * $amplifier)) : 0;

		return $distance * ($tickDifference / 20);
	}

}