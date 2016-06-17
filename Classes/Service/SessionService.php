<?php
/**
 * Session Service
 *
 * @package Html5videoplayerPowermail\Service
 * @author  Tim Lochmüller
 */

namespace HVP\Html5videoplayerPowermail\Service;

/**
 * Session Service
 *
 * @author Tim Lochmüller
 */
class SessionService extends AbstractService
{

    /**
     * Check if the value exists
     *
     * @param string $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Get a vaukue
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            return null;
        }
        return unserialize($_COOKIE[$name]);

    }

    /**
     * Set a value
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function set($name, $value)
    {
        $setValue = serialize($value);
        setcookie($name, $setValue, null, '/');
        $_COOKIE[$name] = $setValue;
    }
}
