<?php 

class Model_Vendor_Row extends Model_Core_Table_Row
{
	protected $tableClass = 'Model_Vendor';

	public function getGender()
	{
		if($this->gender){
			return $this->gender;
		}
		return Model_Vendor::GENDER_MALE;
	}
}