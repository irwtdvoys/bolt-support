<?php
	declare(strict_types=1);

	use Bolt\Arrays;
	use PHPUnit\Framework\TestCase;

	class ArraysTest extends TestCase
	{
		public function testRemoveElement()
		{
			$this->assertSame([1, 3], Arrays::removeElement(2, [1, 2, 3]), "Removing from numeric array");
			$this->assertSame(["a" => 1, "c" => 3], Arrays::removeElement(2, ["a" => 1, "b" => 2, "c" => 3]), "Removing from associative array");
			$this->assertSame(["a" => 1, 1 => 3], Arrays::removeElement(2, ["a" => 1, 2, 3]), "Removing from compound array");
		}

		public function testSubValueSort()
		{
			$data = [];

			for ($loop = 0; $loop < 100; $loop++)
			{
				$data[] = ["id" => rand(0, 50)];
			}

			$asc = Arrays::subValueSort($data, "id", Arrays::ORDER_ASCENDING);
			$desc = Arrays::subValueSort($data, "id", Arrays::ORDER_DESCENDING);

			$current = 0;

			foreach ($asc as $next)
			{
				$this->assertTrue($next['id'] >= $current, "Incorrect order for ascending sort");
				$current = $next['id'];
			}

			$current = 50;

			foreach ($desc as $next)
			{
				$this->assertTrue($next['id'] <= $current, "Incorrect order for descending sort");
				$current = $next['id'];
			}
		}

		public function testType()
		{
			$this->assertSame(Arrays::TYPE_NUMERIC, Arrays::type([1, 2, 3]), "Numeric array");
			$this->assertSame(Arrays::TYPE_ASSOCIATIVE, Arrays::type(["a" => 1, "b" => 2, "c" => 3]), "Associative array");
			$this->assertSame(Arrays::TYPE_ASSOCIATIVE, Arrays::type(["a" => 1, 2, 3]), "Combined array");
			$this->assertSame(Arrays::TYPE_NUMERIC, Arrays::type([1, 2, 3, [4, 5, 6]]), "Nested numeric array");
			$this->assertSame(Arrays::TYPE_ASSOCIATIVE, Arrays::type(["a" => 1, 2, 3, [4, 5, 6]]), "Nested associative array");
		}

		public function testCheck()
		{
			$data = ["a" => 1, "b" => "2", "c" => ["d" => 4]];

			$this->assertTrue(Arrays::check(["a"], $data), "Exists with numeric value");
			$this->assertTrue(Arrays::check(["b"], $data), "Exists with string value");
			$this->assertTrue(Arrays::check(["c" => ["d"]], $data), "Nested value exists");

			$this->assertSame("d", Arrays::check(["d"], $data), "Missing value");
			$this->assertSame("c.e", Arrays::check(["c" => ["e"]], $data), "Missing nested value");
		}

		public function testFilter()
		{
			$data = ["a" => 1, "b" => "2", "c" => ["d" => 4]];

			$this->assertSame(["a" => 1], Arrays::filter(["a"], $data), "Single numeric value");
			$this->assertSame(["b" => "2"], Arrays::filter(["b"], $data), "Single string value");
			$this->assertSame(["c" => ["d" => 4]], Arrays::filter(["c" => ["d"]], $data), "Nested value");
			$this->assertSame(["a" => 1, "c" => ["d" => 4]], Arrays::filter(["a", "c" => ["d"]], $data), "Multi level values");


			$this->assertSame([], Arrays::filter(["d"], $data), "Non-existent value");
			$this->assertSame(["c" => ["d" => 4]], Arrays::filter(["c" => ["d"], "x"], $data), "Existing and non-existent values");

		}
	}
?>
