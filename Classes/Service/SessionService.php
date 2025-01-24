<?php

namespace HVP\Html5videoplayerPowermail\Service;

class SessionService extends AbstractService
{

    /**
     * Check if the value exists
     */
    public function has(string $name):bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @return mixed|null
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            return null;
        }
        return unserialize($_COOKIE[$name]);

    }

    /**
     * Set a value
     *
     * @param mixed  $value
     */
    public function set(string $name, $value):void
    {
        $setValue = serialize($value);
        setcookie($name, $setValue, null, '/');
        $_COOKIE[$name] = $setValue;
    }
}
