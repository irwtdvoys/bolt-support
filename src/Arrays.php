<?php
	declare(strict_types=1);

	namespace Bolt;

	class Arrays
	{
		const TYPE_NUMERIC = "numeric";
		const TYPE_ASSOCIATIVE = "assoc";

		const ORDER_ASCENDING = "ASC";
		const ORDER_DESCENDING = "DESC";

		public static function removeElement($needle, $haystack): array
		{
			return array_values(array_diff($haystack, array($needle)));
		}

		public static function subValueSort(array $array, $subkey, $order = self::ORDER_ASCENDING): array
		{
			$subArray = array();
			$results = array();

			foreach ($array as $key => $value)
			{
				$subArray[$key] = is_string($value[$subkey]) ? strtolower($value[$subkey]) : $value[$subkey];
			}

			switch ($order)
			{
				case self::ORDER_ASCENDING:
					asort($subArray);
					break;
				case self::ORDER_DESCENDING:
					arsort($subArray);
					break;
			}

			foreach ($subArray as $key => $val)
			{
				$results[] = $array[$key];
			}

			return $results;
		}

		public static function type($array)
		{
			if (!is_array($array))
			{
				$result = false;
			}
			elseif (array_values($array) === $array)
			{
				$result = self::TYPE_NUMERIC;
			}
			else
			{
				$result = self::TYPE_ASSOCIATIVE;
			}

			return $result;
		}

		public static function check($keys, $array)
		{
			foreach ($keys as $key => $value)
			{
				if (Arrays::type($keys) === self::TYPE_NUMERIC || is_integer($key))
				{
					$field = $value;
					$data = null;
				}
				else
				{
					$field = $key;
					$data = $value;
				}

				if (!is_array($array) || !isset($array[$field]))
				{
					return $field;
				}

				if ($data !== null)
				{
					$check = self::check($data, $array[$field]);

					if ($check !== true)
					{
						return $field . "." . $check;
					}
				}
			}

			return true;
		}

		public static function filter(array $keys, array $array): array
		{
			$result = array();

			foreach ($keys as $key => $value)
			{
				if (Arrays::type($keys) === self::TYPE_NUMERIC || is_integer($key))
				{
					$field = $value;
					$data = null;
				}
				else
				{
					$field = $key;
					$data = $value;
				}

				if (isset($array[$field]))
				{
					$result[$field] = ($data === null) ? $array[$field] : self::filter($keys[$field], $array[$field]);
				}
			}

			return $result;
		}
	}
?>
