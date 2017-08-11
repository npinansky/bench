<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Determine if a function's sig is compatible with a given argument set
 * Interface ArgumentsFunctionCompatibilityInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface ArgumentsFunctionCompatibilityInterface
{
    /**
     * @param callable $func
     * @param array $args
     * @return bool
     */
    public function isCompatible(callable $func, array $args): bool;
}