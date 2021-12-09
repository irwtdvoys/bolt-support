<?php
	declare(strict_types=1);

	use Bolt\Maths;
	use PHPUnit\Framework\TestCase;

	class MathsTest extends TestCase
	{
		public function testDouble()
		{
			$this->assertSame(2, Maths::double(1));
			$this->assertSame(4, Maths::double(1, 2));

			$this->assertSame(5.0, Maths::double(2.5));
			$this->assertSame(8.8, Maths::double(1.1, 3));
		}

		public function testMean()
		{
			$numbers = [3, 7, 6, 1, 5];
			$this->assertSame(4.4, Maths::mean($numbers));
		}

		public function testMedian()
		{
			$numbers = [3, 7, 6, 1, 5];
			$this->assertSame(5.0, Maths::median($numbers));

			$numbers[] = 10;
			$this->assertSame(5.5, Maths::median($numbers));
		}

		public function testMode()
		{
			$numbers = [3, 1, 6, 1, 5];
			$this->assertSame(1, Maths::mode($numbers));

			$numbers[] = 3;
			$this->assertSame([3, 1], Maths::mode($numbers));
		}

		public function testTau()
		{
			$this->assertSame(6.283185307179586, Maths::tau());
		}

		public function testGcd()
		{
			$this->assertSame(6, Maths::gcd(12, 18));
		}

		public function testLcm()
		{
			$this->assertSame(36, Maths::lcm(12, 18));
		}

		public function testMmi()
		{
			$this->assertSame(12, Maths::mmi(10, 17));
		}

		public function testCrt()
		{
			$numbers = [3, 4, 5];
			$remainders = [2, 3, 1];

			$this->assertSame(11, Maths::crt($numbers, $remainders));

			$numbers = [5, 7];
			$remainders = [1, 3];

			$this->assertSame(31, Maths::crt($numbers, $remainders));
		}
	}
?>
