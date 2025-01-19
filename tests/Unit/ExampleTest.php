<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $color = random_int(0, 6);
        $size = random_int(0, 4);

        $colorVariation = ['BLUE', 'RED', 'BLACK', 'WHITE', 'YELLOW', 'GRAY', 'GREEN'];
        $sizeVariation = ['PP', 'P', 'M', 'G', 'GG'];

        dump([
            'color' => $colorVariation[$color],
            'size' => $sizeVariation[$size]
        ]);

        $this->assertTrue(true);
    }
}
