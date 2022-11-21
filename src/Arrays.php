<?php
	declare(strict_types=1);

	namespace Bolt;

	use Bolt\Enums\Arrays\Orders;
	use Bolt\Enums\Arrays\Types;

	class Arrays
	{
		public static function removeElement($needle, $haystack): array
		{
			$removed = array_diff($haystack, array($needle));

			return (self::type($haystack) === Types::Numeric) ? array_values($removed) : $removed;
		}

		public static function subValueSort(array $array, string $subkey, Orders $order = Orders::Ascending): array
		{
			$subArray = array();
			$results = array();

			foreach ($array as $key => $value)
			{
				$subArray[$key] = is_string($value[$subkey]) ? strtolower($value[$subkey]) : $value[$subkey];
			}

			switch ($order)
			{
				case Orders::Ascending:
					asort($subArray);
					break;
				case Orders::Descending:
					arsort($subArray);
					break;
			}

			foreach ($subArray as $key => $val)
			{
				$results[] = $array[$key];
			}

			return $results;
		}

		public static function type(array $array): Types
		{
			return (array_values($array) === $array) ? Types::Numeric : Types::Associative;
		}

		public static function check($keys, $array)
		{
			foreach ($keys as $key => $value)
			{
				if (Arrays::type($keys) === Types::Numeric || is_integer($key))
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
				if (Arrays::type($keys) === Types::Numeric || is_integer($key))
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
