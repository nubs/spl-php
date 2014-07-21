<?php

namespace Chadicus\Spl;

interface Stringable extends Object
{
    /**
     * Converts the implementing object to a string.
     *
     * @return string
     */
    public function __toString();
}
