<?php
use Dtool\Help;
use PHPUnit\Framework\TestCase;

class TestHelp extends TestCase
{
    public function testHello() {
        $r = Help::hello();
        $this->assertStringContainsString("hello world!", $r);
    }
}