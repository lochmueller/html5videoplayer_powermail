<?php

namespace HVP\Html5videoplayerPowermail\Slots;

use HVP\Html5videoplayerPowermail\Service\AccessService;

class Videoplayer
{


    /**
     * Get the access service+
     *
     * @return AccessService
     */
    protected function getAccessService()
    {
        $objectManager = new ObjectManager();
        return $objectManager->get(AccessService::class);
    }

    /**
     * Slot for html5videoplayer
     *
     * @param $videos
     * @param $video
     *
     * @return void
     */
    public function detailAction($videos, $video)
    {
        $this->getAccessService()
            ->checkVideoAccess($video);
    }
}
