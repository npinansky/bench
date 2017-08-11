<?php
declare(strict_types=1);


namespace Benchmark;

use Benchmark\Exception\FunctionSignatureMismatchException;

/**
 * A comparitor will execute a given set of callables (i) against j sets of arguments executed k times per permutation
 * to create a sample population of execution times from which we can draw inferences of the performance
 * of the code within the callables as applied to the various configurations of arguments.
 *
 * Interface ComparitorInterface
 * @package Benchmark
 * @author Nick Pinansky <pinansky@gmail.com>
 */
interface ComparitorInterface
{
    /**
     * ComparitorInterface constructor.
     * @param SignatureHashGeneratorInterface $hashGenerator
     */
    public function __construct(FunctionSignatureCompatibilityInterface $hashGenerator);

    /**
     * Add a function for comparison.
     * @param string $name Human readable name for the callable (for use with reporting)
     * @param callable $function Callable to benchmark
     * @return ComparitorInterface
     * @throws FunctionSignatureMismatchException
     */
    public function addFunction(string $name, callable $function): self;

    /**
     * @param string $name
     * @return ComparitorInterface
     */
    public function removeFunction(string $name): self;

    /**
     * Add a set of arguments to be tested against each function
     * @param string $name The name of the argument set for use in reporting.
     * @param array $args A list of arguments to be passed to each function
     * @return ComparitorInterface
     */
    public function addArgumentSet(string $name, array $args): self;

    public function removeArgumentSet(string $name): self;

    /**
     * Execute each function N times per argument set and return the results.
     * @param int $iterations
     * @return ComparitorResultsInterface
     */
    public function compare(int $iterations) : ComparitorResultsInterface;
}