<?php

class Model_Service extends ORM
{

	protected $_has_many  = array('service_data' => array());
	protected $_belongs_to = array('service_type' => array('foreign_key' => 'id'));

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('max_length',array(':value',255)),
			),
			'user_id' => array(
				array('not_empty'),
				array('numeric'),
			),
			'type_id' => array(
				array('not_empty'),
				array('numeric'),
			),
			'check_interval' => array(
				array('not_empty'),
				array('numeric'),
			),
			'settings' => array(
				array('not_empty'),
			),
		);
	}

	public function is_acceptable($data)
	{
		if ($this->okay != null)
		{
			$values = explode("-",$this->okay);
			$low = $values[0];
			$high = $values[1];
			if ($low <= $data->data and $data->data <= $high)
				return true;
			if ($this->warning != null)
			{
				//TODO implement me!
				return false;
			}
			return false;
		}
		else
			return $this->service_type->find()->is_acceptable($data);
	}

}

