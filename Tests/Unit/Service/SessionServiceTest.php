<?php
/**
 * SessionServiceTest
 */

namespace FRUIT\Html5videoplayerPowermail\Tests\Unit\Service;

use FRUIT\Html5videoplayerPowermail\Service\SessionService;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * SessionServiceTest
 */
class SessionServiceTest extends UnitTestCase
{

    /**
     * @test
     */
    public function testSetAndGet()
    {
        $service = new SessionService();
        $service->set('test', 'value');
        $this->assertEquals('value', $service->get('test'));

    }

    /**
     * @test
     */
    public function testSetAndHas()
    {
        $service = new SessionService();
        $service->set('test', 'value');
        $this->assertEquals(true, $service->has('test'));
    }
}
