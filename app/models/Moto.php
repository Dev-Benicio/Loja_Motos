<?php

namespace App\Models;

class Moto implements crud
{
	public static function create(array $moto): bool
	{
		return false;
	}

	public static function read(int $id = null): mysqli_result
	{
		return;
	}

	public static function update(int $id, array $moto): bool
	{
		return false;
	}

	public  static function delete(int $id): bool
	{
		return false;
	}
}
