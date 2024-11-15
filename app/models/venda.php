<?php

namespace App\Models;

class Vendas implements crud
{
	public static function create(array $venda): bool
	{
		return false;
	}

	public static function read(int $id = null): mysqli_result
	{
		return;
	}

	public static function update(int $id, array $venda): bool
	{
		return false;
	}

	public  static function delete(int $id): bool
	{
		return false;
	}
}
