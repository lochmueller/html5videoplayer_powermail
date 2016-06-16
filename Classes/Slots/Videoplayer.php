<?php
/**
 * Slot for html5videoplayer
 *
 * @package Html5videoplayerPowermail\Slots
 * @author  Tim Lochmüller
 */

namespace FRUIT\Html5videoplayerPowermail\Slots;

/**
 * Slot for html5videoplayer
 *
 * @author Tim Lochmüller
 */
class Videoplayer extends AbstractSlot {

	/**
	 * Slot for html5videoplayer
	 *
	 * @param $videos
	 * @param $video
	 *
	 * @return void
	 */
	public function detailAction($videos, $video) {
		$this->getAccessService()
			->checkVideoAccess($video);
	}

}
