<?php

namespace Mateusjatenee\Iugu;

trait Singleton
{
    /**
     * Set the globally available instance of the class.
     *
     * @return static
     */
    public static function getInstance(...$args)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(...$args);
        }

        return static::$instance;
    }

    /**
     * Set the shared instance of the class.
     *
     * @param  $container
     * @return static
     */
    public static function setInstance($object = null)
    {
        return static::$instance = $object;
    }
}
