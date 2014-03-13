<?php defined('SYSPATH') or die('No direct script access.');

class View_User_Info extends View_Layout_Template {

	public function fuzzy_date()
	{
		return Date::fuzzy_span($this->user->last_login);
	}
}
