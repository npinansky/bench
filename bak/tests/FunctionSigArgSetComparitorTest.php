<?php
declare(strict_types=1);

namespace tests;

use Benchmark\ArgumentsFunctionCompatibilityInterface;
use Benchmark\FunctionSigArgSetComparitor;
use PHPUnit\Framework\TestCase;

class FunctionSigArgSetComparitorTest extends TestCase
{
    /**
     * @var FunctionSigArgSetComparitor
     */
    private $subject;

    public function setUp()
    {
        $this->subject = new FunctionSigArgSetComparitor();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ArgumentsFunctionCompatibilityInterface::class, $this->subject);
    }

    public function testIsCompatible()
    {
        $func = function () {
        };

        $f1 = function ($arg) {
        };

        $f2 = function ($arg = 1) {
        };

        $f3 = function (int $arg) {
        };

        $f4 = function (int $arg = null) {
        };

        $f5 = function (int $arg = null, string $abc) {
        };

        $f6 = function (FunctionSigArgSetComparitorTest $x) {
        };


        $this->assertTrue($this->subject->isCompatible($f1, ['abc']));
        $this->assertFalse($this->subject->isCompatible($f1, []));
        $this->assertTrue($this->subject->isCompatible($func, []));

        // engage untyped optional param
        $this->assertTrue($this->subject->isCompatible($f2, []));

        // engage untyped optional param, with explicit null
        $this->assertTrue($this->subject->isCompatible($f2, [null]));

        $this->assertTrue($this->subject->isCompatible($f2, ['abc']));

        // pass more args than params to receive
        $this->assertFalse($this->subject->isCompatible($f2, ['abc',2]));


        // try a good type on a typed param
        $this->assertTrue($this->subject->isCompatible($f3, [2]));

        // try a bad type on a typed param
        $this->assertFalse($this->subject->isCompatible($f3, ['abc']));

        $this->assertFalse($this->subject->isCompatible($f3, [null]));
        $this->assertTrue($this->subject->isCompatible($f4, [null]));


        $this->assertTrue($this->subject->isCompatible($f5, [1, 'abc']));
        $this->assertTrue($this->subject->isCompatible($f5, [null, 'abc']));
        $this->assertFalse($this->subject->isCompatible($f5, [1,null]));

        $this->assertTrue($this->subject->isCompatible($f6, [$this]));
        $this->assertFalse($this->subject->isCompatible($f6, [new \stdClass()]));
    }
}
