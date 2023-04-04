<?php 

class Model_Product_Media extends Model_Core_Table
{
	public function __construct()
	{
		$this->setTableName('product_media')->setPrimaryKey('image_id');
	}

	public function update($arrayData, $condition)
	{
		$data = [];
		foreach ($arrayData as $key => $value) {
			$data[] = "`{$key}` = '{$value}'";
		}

		$dataString = implode(',', $data);
		if(is_array($condition)){
			$whereString = "`{$this->getPrimaryKey()}` IN ('".implode("','", $condition)."')";
		}
		else{
			$whereString = "`{$this->getPrimaryKey()}` = {$condition}";
		}

		$sql = "UPDATE `{$this->getTableName()}` SET {$dataString} WHERE {$whereString}";
		return $this->getAdapter()->update($sql);
	}
}
