<?php

namespace Ixolit\Dislo\Helper;

/**
 * Trait ReflectionHelper
 *
 * @package Helper
 */
trait ReflectionHelper
{
    /**
     * @param mixed  $object
     * @param string $methodName
     * @param array  $parameters
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function runProtectedMethod($object, $methodName, array $parameters = [])
    {
        $reflectionMethod = $this->getReflectionObject($object)->getMethod($methodName);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs($object, $parameters);
    }

    /**
     * @param mixed $object
     *
     * @return \ReflectionObject
     */
    protected function getReflectionObject($object)
    {
        return new \ReflectionObject($object);
    }
}
