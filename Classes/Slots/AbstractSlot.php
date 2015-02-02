<?php
/**
 * General Slot information
 *
 * @package Html5videoplayerPowermail\Slots
 * @author  Tim Lochmüller
 */

namespace FRUIT\Html5videoplayerPowermail\Slots;

use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * General Slot information
 *
 * @author     Tim Lochmüller
 */
abstract class AbstractSlot {

	/**
	 * Get the access service+
	 *
	 * @return \FRUIT\Html5videoplayerPowermail\Service\AccessService
	 */
	protected function getAccessService() {
		$objectManager = new ObjectManager();
		return $objectManager->get('FRUIT\\Html5videoplayerPowermail\\Service\\AccessService');
	}
}