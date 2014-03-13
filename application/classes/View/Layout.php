<?php defined('SYSPATH') or die('No direct script access.');

abstract class View_Layout {

	public function action()
	{
		URL::site($this->request->uri()).URL::query();
	}

	public function base()
	{
		return URL::base(FALSE, TRUE);
	}
}
