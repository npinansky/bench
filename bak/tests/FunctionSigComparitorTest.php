<?php
declare(strict_types=1);

namespace tests;

use Benchmark\FunctionSigComparitor;
use Benchmark\FunctionSignatureCompatibilityInterface;
use PHPUnit\Framework\TestCase;

class FunctionSigComparitorTest extends TestCase
{
    /**
     * @var FunctionSigComparitor
     */
    private $subject;

    public function setUp()
    {
        $this->subject = new FunctionSigComparitor();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(FunctionSignatureCompatibilityInterface::class, $this->subject);
    }

    public function testIsCompatible()
    {
        $f1 = function () {};

        $this->assertTrue($this->subject->isCompatible($f1, $f1));
    }

}
