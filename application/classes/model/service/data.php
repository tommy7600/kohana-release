<?php

class Model_Service_Data extends ORM
{
	protected $_table_name = 'service_data';
	protected $_belongs_to = array('service' => array());
}

