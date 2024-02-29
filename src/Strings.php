<?php
	declare(strict_types=1);

	namespace Bolt;

	use Bolt\Enums\Strings\Matches;
	use Bolt\Enums\Strings\Strength;

	class Strings
	{
		public static function findOverlaps(string $str1, string $str2): array|false
		{
			$result = array();
			$sl1 = strlen($str1);
			$sl2 = strlen($str2);
			$max = ($sl1 > $sl2) ? $sl2 : $sl1;
			$i = 1;

			while ($i <= $max)
			{
				$s1 = substr($str1, $sl1 - $i);
				$s2 = substr($str2, 0, $i);

				if ($s1 == $s2)
				{
					$result[] = $s1;
				}

				$i++;
			}

			if (!empty($result))
			{
				return $result;
			}

			return false;
		}

		public static function replaceOverlap(string $str1, string $str2, Matches $type = Matches::Last): string|false
		{
			$overlaps = Strings::findOverlaps($str1, $str2);

			if ($overlaps === false)
			{
				return false;
			}

			$overlap = match ($type)
			{
				Matches::First => $overlaps[0],
				default => $overlaps[count($overlaps) - 1],
			};

			$str1 = substr($str1, 0, -strlen($overlap));
			$str2 = substr($str2, strlen($overlap));

			return $str1 . $overlap . $str2;
		}

		public static function random(int $length, Strength $type = Strength::High): string
		{
			$string = "";

			$characters = match ($type)
			{
				Strength::Numeric => "0123456789",
				Strength::Low => "ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz",
				Strength::Medium => "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz",
				default => "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz+=!-_",
			};

			$charLoop = 0;

			while (($charLoop < $length) && (strlen($characters) > 0))
			{
				$charLoop++;
				$character = substr($characters, mt_rand(0, strlen($characters)-1), 1);
				$string .= $character;
			}

			return $string;
		}

		public static function isRegex(string $string): bool
		{
			return !(preg_match("/^\/[\s\S]+\/[gmixXsuUAJD]?$/", $string) !== 1);
		}

		public static function isJson($value): bool
		{
			json_decode($value);

			return (json_last_error() == JSON_ERROR_NONE);
		}

		public static function diff(string $a, string $b): array
		{
			return array_diff_assoc(str_split($a), str_split($b));
		}
	}
?>
