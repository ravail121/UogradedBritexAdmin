<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

/**
 * Class UsersImport
 *
 * @package App\Imports
 */
class UsersImport implements ToCollection
{

	/**
	 * @var
	 */
	public $value;

	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function collection(Collection $rows)
	{
		$this->value = $rows;
	}

	/**
	 * @return mixed
	 */
	public function data()
	{
		return $this->value;
	}
}
