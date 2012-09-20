<?php

class Model_Service_Type extends ORM
{

	public function is_acceptable($data)
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
}

