<?php 

class Model_Customer extends Model_Core_Table
{
	const GENDER_MALE = 'Male';
	const GENDER_FEMALE = 'Female';
	const GENDER_OTHER = 'Other';

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('customer')->setPrimaryKey('customer_id');
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