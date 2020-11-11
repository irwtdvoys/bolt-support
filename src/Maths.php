<?php
	namespace Bolt;

	class Maths
	{
		public static function _double($value, $iterations = 1)
		{
			trigger_error("Deprecated method `_double` called, use `double` instead", E_USER_NOTICE);

			return self::double($value, $iterations);
		}

		public static function double($value, $iterations = 1)
		{
			$result = $value;

			if ($iterations > 0)
			{
				$result = self::double($result * 2, ($iterations - 1));
			}

			return $result;
		}

		public static function average(array $numbers): float
		{
			return self::mean($numbers);
		}

		public static function mean(array $numbers): float
		{
			$count = 0;
			$total = 0;

			foreach ($numbers as $next)
			{
				if (is_numeric($next))
				{
					$total += $next;
					$count++;
				}
			}

			return ($total === 0 || $count === 0) ? 0 : $total / $count;
		}

		public static function median($numbers)
		{
			asort($numbers);

			$data = (array_values($numbers));
			$point = (count($data) - 1) / 2;

			if (is_integer($point))
			{
				return $data[$point];
			}

			$points = array(
				$data[(int)floor($point)],
				$data[(int)ceil($point)]
			);

			return self::mean($points);
		}

		public static function mode($numbers)
		{
			$counts = array_count_values($numbers);

			$max = max($counts);

			$results = array();

			foreach ($counts as $key => $value)
			{
				if ($value === $max)
				{
					$results[] = $key;
				}
			}

			return count($results) === 1 ? $results[0] : $results;
		}

		public static function tau()
		{
			return 2 * pi();
		}

		/**
		 * Greatest Common Divisor
		 */
		public static function gcd(int $a, int $b): int
		{
			if ($a == 0)
			{
				return $b;
			}

			return self::gcd($b % $a, $a);
		}

		/**
		 * Lowest Common Multiple
		 */
		public static function lcm(int $a, int $b): int
		{
			return ($a * $b) / self::gcd($a, $b);
		}
	}
?>
