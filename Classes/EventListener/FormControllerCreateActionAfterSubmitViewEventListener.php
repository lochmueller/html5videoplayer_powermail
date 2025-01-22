<?php

namespace HVP\Html5videoplayerPowermail\EventListener;

use HVP\Html5videoplayerPowermail\Service\AccessService;
use In2code\Powermail\Events\FormControllerCreateActionAfterSubmitViewEvent;

class FormControllerCreateActionAfterSubmitViewEventListener
{

    protected AccessService $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    public function __invoke(FormControllerCreateActionAfterSubmitViewEvent $event)
    {
        $this->accessService->triggerFormSubmit($event->getMail()->getForm());
    }

}
