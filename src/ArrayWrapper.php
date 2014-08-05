<?php
namespace Chadicus\Spl;

interface ArrayWrapper extends Object
{
    /**
     * Creates a copy of the array.
     *
     * @return array Returns a copy of the array.
     */
    public function getArrayCopy();

    /**
     * Exchange the array for another one.
     *
     * @param array $input The new array to exchange with the current array.
     *
     * @return array Returns the old array.
     */
    public function exchangeArray(array $input);
}
