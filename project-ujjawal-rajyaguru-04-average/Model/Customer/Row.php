<?php 

class Model_Customer_Row extends Model_Core_Table_Row
{
	protected $tableClass = 'Model_Customer';

	public function getGender()
	{
		if($this->gender){
			return $this->gender;
		}
		return Model_Customer::GENDER_MALE;
	}
}