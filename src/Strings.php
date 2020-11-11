<?php
	declare(strict_types=1);

	namespace Bolt;

	class Strings
	{
		const STRENGTH_HIGH = "high";
		const STRENGTH_MEDIUM = "medium";
		const STRENGTH_LOW = "low";
		const STRENGTH_NUMERIC = "numeric";

		const LENGTH_SHORT = "short";
		const LENGTH_LONG = "long";

		public static function findOverlap($str1, $str2)
		{
			$return = array();
			$sl1 = strlen($str1);
			$sl2 = strlen($str2);
			$max = ($sl1 > $sl2) ? $sl2 : $sl1;
			$i = 1;

			while ($i <= $max)
			{
				$s1 = substr($str1, $sl1-$i);
				$s2 = substr($str2, 0, $i);

				if ($s1 == $s2)
				{
					$return[] = $s1;
				}

				$i++;
			}

			if (!empty($return))
			{
				return $return;
			}

			return false;
		}

		public static function replaceOverlap($str1, $str2, $length = self::LENGTH_LONG)
		{
			if ($overlap = Strings::findOverlap($str1, $str2))
			{
				switch ($length)
				{
					case self::LENGTH_SHORT:
						$overlap = $overlap[0];
						break;
					case self::LENGTH_LONG:
					default:
						$overlap = $overlap[count($overlap) - 1];
						break;
				}

				$str1 = substr($str1, 0, -strlen($overlap));
				$str2 = substr($str2, strlen($overlap));
				return $str1 . $overlap . $str2;
			}

			return false;
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
