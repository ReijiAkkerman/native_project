<?php
    use PHPUnit\Framework\TestCase;
    use project\control\Test;

    final class TestTest extends TestCase {
        public function testGetPage(): void {
            $obj = new Test;
            $string = $obj->getPage();
            $this->assertSame('Hello', $string);
        }
    }