<?php
	declare(strict_types=1);

	use Bolt\Enums\Strings\Matches;
	use Bolt\Enums\Strings\Strength;
	use Bolt\Strings;
	use PHPUnit\Framework\TestCase;

	class StringsTest extends TestCase
	{
		public function testFindOverlap()
		{
			$this->assertSame(["plane"], Strings::findOverlaps("airplane", "planetary"), "Expected single overlap not returned");
			$this->assertSame(["x", "xcdex"], Strings::findOverlaps("abxcdex", "xcdexfg"), "Expected multiple overlaps not returned");
			$this->assertFalse(Strings::findOverlaps("Hello", "World"), "No overlap not detected");
		}

		public function testReplaceOverlap()
		{

			$this->assertFalse(Strings::replaceOverlap("intergalactic", "planetary"), "Expected no match");
			$this->assertSame("airplanetary", Strings::replaceOverlap("airplane", "planetary", Matches::First), "Unexpected result on single first match");
			$this->assertSame("airplanetary", Strings::replaceOverlap("airplane", "planetary", Matches::Last), "Unexpected result on single last match");
			$this->assertSame("abxcdexcdexfg", Strings::replaceOverlap("abxcdex", "xcdexfg", Matches::First), "Unexpected result on multiple first match");
			$this->assertSame("abxcdexfg", Strings::replaceOverlap("abxcdex", "xcdexfg", Matches::Last), "Unexpected result on multiple last match");
		}

		public function testRandom()
		{
			$numeric = Strings::random(100, Strength::Numeric);
			$low = Strings::random(10000, Strength::Low);
			$medium = Strings::random(10000, Strength::Medium);
			$high = Strings::random(10000, Strength::High);

			$this->assertIsString($numeric);
			$this->assertSame(100, strlen($numeric));

			$this->assertMatchesRegularExpression("/^[0-9]*$/", $numeric, "Numeric strength result contains invalid characters");
			$this->assertMatchesRegularExpression("/^[A-z]*$/", $low, "Low strength result contains invalid characters");
			$this->assertMatchesRegularExpression("/^[A-z0-9]*$/", $medium, "Medium strength result contains invalid characters");
			$this->assertMatchesRegularExpression("/^[A-z0-9+=!_-]*$/", $high, "High strength result contains invalid characters");
		}

		public function testIsRegex()
		{
			$this->assertFalse(Strings::isRegex("hello world"));
			$this->assertFalse(Strings::isRegex("["));

			$this->assertTrue(Strings::isRegex("/^hello world$/"));
			$this->assertTrue(Strings::isRegex("/./"));
			$this->assertTrue(Strings::isRegex("/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i"));
			$this->assertTrue(Strings::isRegex("/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/"));
		}

		public function testIsJson()
		{
			$this->assertTrue(Strings::isJson('null'));
			$this->assertTrue(Strings::isJson('""'));
			$this->assertTrue(Strings::isJson('1'));
			$this->assertTrue(Strings::isJson('[1]'));
			$this->assertTrue(Strings::isJson('{"test":1}'));

			$this->assertFalse(Strings::isJson(''));
			$this->assertFalse(Strings::isJson('{1}'));
			$this->assertFalse(Strings::isJson('This is invalid'));
		}

		public function testDiff()
		{
			$this->assertSame([2 => "i", 3 => "s"], Strings::diff("This", "That"));
			$this->assertSame([3 => "t"], Strings::diff("testing", "tesTing"));
		}
	}
?>
