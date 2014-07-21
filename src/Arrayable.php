<?php
namespace Chadicus\Spl;

interface Arrayable extends Object
{
    /**
     * Converts the implementing object into an array.
     *
     * @return array
     */
    public function toArray();
}
