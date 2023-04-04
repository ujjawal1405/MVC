<?php 

class Model_Vendor extends Model_Core_Table
{	const GENDER_MALE = 'Male';
	const GENDER_FEMALE = 'Female';
	const GENDER_OTHER = 'Other';

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('vendor')->setPrimaryKey('vendor_id');
	}

	public function getGenderOptions()
	{
		return [
			self::GENDER_MALE,
			self::GENDER_FEMALE,
			self::GENDER_OTHER,
		];
	}
}