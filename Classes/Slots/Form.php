<?php
/**
 * Slot for powermail
 *
 * @package Html5videoplayerPowermail\Slots
 * @author  Tim Lochmüller
 */


namespace FRUIT\Html5videoplayerPowermail\Slots;

use In2code\Powermail\Controller\FormController;
use In2code\Powermail\Domain\Model\Mail;

/**
 * Slot for powermail
 *
 * @author Tim Lochmüller
 */
class Form extends AbstractSlot {

	/**
	 * Slot for powermail
	 *
	 * @param Mail           $mail
	 * @param string         $hash
	 * @param FormController $formController
	 */
	public function createActionAfterSubmitView(Mail $mail, $hash, FormController $formController) {
		$this->getAccessService()
			->triggerFormSubmit($mail->getForm());
	}

}