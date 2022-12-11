<?php
	declare(strict_types=1);

	namespace Bolt;

	use Exception;

	class Maths
	{
		public static function double(int|float $value, int $iterations = 1): int|float
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

		public static function median(array $numbers): float
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

		public static function mode(array $numbers)
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

		public static function tau(): float
		{
			return 2 * pi();
		}

		/**
		 * Greatest Common Divisor
		 * https://en.wikipedia.org/wiki/Greatest_common_divisor
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
		 * https://en.wikipedia.org/wiki/Least_common_multiple
		 */
		public static function lcm(int ...$values): int
		{
			if (count($values) < 2)
			{
				throw new Exception("2 or more values required");
			}

			return ($values[0] * $values[1]) / self::gcd($values[0], $values[1]);
		}

		/**
		 * Modular Multiplicative Inverse
		 * https://en.wikipedia.org/wiki/Modular_multiplicative_inverse
		 */
		public static function mmi(int $a, int $m): int
		{
			if ($m === 1)
			{
				return 1;
			}

			for ($i = 1; $i <= $m; $i++)
			{
				if ($a * $i % $m === 1)
				{
					return $i;
				}
			}

			return 0;
		}

		/**
		 * Chinese Remainder Theorem
		 * https://en.wikipedia.org/wiki/Chinese_remainder_theorem
		 */
		public static function crt(array $n, array $r): int
		{
			if (count($n) !== count($r))
			{
				throw new Exception("Input arrays must be the same size");
			}

			$prod = 1;
			$sum = 0;
			$ln = count($n) - 1;

			for ($p = 0; $p < $ln; $p++)
			{
				for ($i = $p + 1; $i <= $ln; $i++)
				{
					if (self::gcd($n[$i], $n[$p]) > 1)
					{
						throw new Exception("'n' not coprime");
					}
				}
			}

			for ($i = 0; $i <= $ln; $i++)
			{
				$prod *= $n[$i];
			}

			for ($i = 0; $i <= $ln; $i++)
			{
				$p = $prod / $n[$i];
				$sum += $r[$i] * self::mmi($p, $n[$i]) * $p;
			}

			return $sum % $prod;
		}

		/**
		 * Calculate nth Triangular number
		 * https://en.wikipedia.org/wiki/Triangular_number
		 */
		public static function triangular(int $n): int
		{
			return ($n * ($n + 1)) / 2;
		}
	}
?>
