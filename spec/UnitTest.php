<?php

namespace spec;

use Faker\Factory;
use Faker\Generator;
use PhpSpec\ObjectBehavior;

/**
 * Class UnitTest
 * @package spec
 */
abstract class UnitTest extends ObjectBehavior
{

    /**
     * @var \Faker\Generator
     */
    protected Generator $generator;

    /**
     *
     */
    public function __construct()
    {
        $this->generator = Factory::create();
    }

    /**
     * @return string
     */
    protected function randomEmptyString(): string
    {
        $times = mt_rand(0, 5);
        $newline = mt_rand(0, 1) === 0 ? "\n" : '';
        return str_repeat(string: ' ' . $newline, times: $times);
    }
}
