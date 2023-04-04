<?php 

class Model_Salesman_Row extends Model_Core_Table_Row
{
	protected $tableClass = 'Model_Salesman';

	public function getGender()
	{
		if($this->gender){
			return $this->gender;
		}
		return Model_Salesman::GENDER_MALE;
	}
}