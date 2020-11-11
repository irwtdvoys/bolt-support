<?php
	declare(strict_types=1);

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
			$this->assertSame("airplanetary", Strings::replaceOverlap("airplane", "planetary", Strings::MATCH_FIRST), "Unexpected result on single first match");
			$this->assertSame("airplanetary", Strings::replaceOverlap("airplane", "planetary", Strings::MATCH_LAST), "Unexpected result on single last match");
			$this->assertSame("abxcdexcdexfg", Strings::replaceOverlap("abxcdex", "xcdexfg", Strings::MATCH_FIRST), "Unexpected result on multiple first match");
			$this->assertSame("abxcdexfg", Strings::replaceOverlap("abxcdex", "xcdexfg", Strings::MATCH_LAST), "Unexpected result on multiple last match");
		}

		public function testRandom()
		{
			$numeric = Strings::random(100, Strings::STRENGTH_NUMERIC);
			$low = Strings::random(10000, Strings::STRENGTH_LOW);
			$medium = Strings::random(10000, Strings::STRENGTH_MEDIUM);
			$high = Strings::random(10000, Strings::STRENGTH_HIGH);

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

			$this->assertTrue(Strings::isRegex("/^hello world$/"));
			$this->assertTrue(Strings::isRegex("/./"));
			$this->assertTrue(Strings::isRegex("/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i"));
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
	}
?>
