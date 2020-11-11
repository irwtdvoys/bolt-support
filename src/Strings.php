<?php
	declare(strict_types=1);

	namespace Bolt;

	class Strings
	{
		const STRENGTH_HIGH = "high";
		const STRENGTH_MEDIUM = "medium";
		const STRENGTH_LOW = "low";
		const STRENGTH_NUMERIC = "numeric";

		const MATCH_FIRST = "first";
		const MATCH_LAST = "last";

		public static function findOverlaps($str1, $str2)
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

		public static function replaceOverlap($str1, $str2, $length = self::MATCH_LAST)
		{
			$overlaps = Strings::findOverlaps($str1, $str2);

			if ($overlaps === false)
			{
				return false;
			}

			switch ($length)
			{
				case self::MATCH_FIRST:
					$overlap = $overlaps[0];
					break;
				case self::MATCH_LAST:
				default:
					$overlap = $overlaps[count($overlaps) - 1];
					break;
			}

			$str1 = substr($str1, 0, -strlen($overlap));
			$str2 = substr($str2, strlen($overlap));

			return $str1 . $overlap . $str2;
		}

		public static function random(int $length, $type = self::STRENGTH_HIGH): string
		{
			$string = "";

			switch ($type)
			{
				case self::STRENGTH_NUMERIC:
					$characters = "0123456789";
					break;
				case self::STRENGTH_HIGH:
					$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz+=!-_";
					break;
				case self::STRENGTH_MEDIUM:
					$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz";
					break;
				case self::STRENGTH_LOW:
				default:
					$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZacbdefghijklmnopqrstuvwxyz";
					break;
			}

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
			return preg_match("/^\/[\s\S]+\/$/", $string) == 1 ? true : false;
		}

		public static function isJson($value): bool
		{
			json_decode($value);

			return (json_last_error() == JSON_ERROR_NONE);
		}
	}
?>
