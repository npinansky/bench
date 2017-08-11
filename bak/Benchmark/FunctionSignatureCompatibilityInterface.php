<?php
declare(strict_types=1);


namespace Benchmark;

/**
 * Determine if two functions contain compatible signitures
 * Interface FunctionSignatureCompatibilityInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface FunctionSignatureCompatibilityInterface
{
    /**
     * Checks if two functions have compatible signatures
     * @param callable $func1
     * @param callable $func2
     * @return bool
     */
    public function isCompatible(callable $func1, callable $func2): bool;
}