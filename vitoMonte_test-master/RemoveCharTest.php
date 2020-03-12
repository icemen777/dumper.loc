<?php
use PHPUnit\Framework\TestCase;



function invert(array $a): array {
    foreach ($a as $key => $v) {
        $a[$key]=$a[$key]*-1;
    }
    return ($a);
}

class RemoveCharTest extends TestCase {
    public function testFixed() {
        $this->assertEquals([-1, -2, -3, -4, -5], invert([1, 2, 3, 4, 5]));
        $this->assertEquals([-1, 2, -3, 4, -5], invert([1, -2, 3, -4, 5]));
        $this->assertEquals([], invert([]));
        $this->assertEquals([0], invert([0]));
    }
}