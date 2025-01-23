<?php

namespace HVP\Html5videoplayerPowermail\EventListener;

use HVP\Html5videoplayer\Domain\Model\Video;
use HVP\Html5videoplayer\Event\DetailActionVariablesEvent;
use HVP\Html5videoplayerPowermail\Service\AccessService;

class DetailActionVariablesEventListener
{

    protected AccessService $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    public function __invoke(DetailActionVariablesEvent $event):void
    {
        /** @var Video $video */
        $video = $event->variables['currentVideo'];
        $this->accessService->checkVideoAccess($video);
    }

}
