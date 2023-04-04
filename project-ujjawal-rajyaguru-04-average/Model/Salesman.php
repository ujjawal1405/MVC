<?php 

class Model_Salesman extends Model_Core_Table
{
	const GENDER_MALE = 'Male';
	const GENDER_FEMALE = 'Female';
	const GENDER_OTHER = 'Other';

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('salesman')->setPrimaryKey('salesman_id');
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