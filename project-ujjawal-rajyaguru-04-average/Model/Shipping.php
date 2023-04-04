<?php 

class Model_Shipping extends Model_Core_Table
{
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('shipping')->setPrimaryKey('shipping_id');
	}
}