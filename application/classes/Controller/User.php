<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_User extends Controller {
 
	public function action_index()
	{
		// Load the user information
		$user = Auth::instance()->get_user();
		 
		// if a user is not logged in, redirect to login page
		if (!$user)
		{
			$this->redirect('user/login');
		}

		$view = new View_User_Info;
		$view->user = $user;
		$view->request = $this->request;

		$renderer = Kostache_Layout::factory('Layout/Template');
		$this->response->body($renderer->render($view));
	}
 
	public function action_create() 
	{
		$message = NULL;
		$errors = array();		 
	
		if (HTTP_Request::POST == $this->request->method()) 
		{		   
			try {
		 
				// Create the user using form values
				$user = ORM::factory('User')->create_user($this->request->post(), array(
					'username',
					'password',
					'email'			
				));
				 
				// Grant user login role
				$user->add('roles', ORM::factory('Role', array('name' => 'login')));
				 
				// Reset values so form is not sticky
				$_POST = array();
				 
				// Set success message
				$message = "You have added user '{$user->username}' to the database";
				 
			} catch (ORM_Validation_Exception $e) {
				 
				// Set failure message
				$message = 'There were errors, please see form below.';
				 
				// Set errors using custom messages
				$errors = $e->errors('models');
			}
		}

		$view = new View_User_Create;
		$view->message = $message;
		$view->errors = $errors;
		$view->request = $this->request;

		$renderer = Kostache_Layout::factory('Layout/Template');
		$this->response->body($renderer->render($view));
	}
	 
	public function action_login() 
	{
		$message = NULL;
			 
		if (HTTP_Request::POST == $this->request->method()) 
		{
			// Attempt to login user
			print_r($this->request->post());
			$remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
			Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);

			$user = auth::instance()->get_user();

			// If successful, redirect user
			if ($user) 
			{
				$this->redirect('user/index');
			} 
			else
			{
				$message = 'Login failed';
			}
		}

	$view = new View_User_Login;
	$view->message = $message;
	$view->request = $this->request;
	$view->post = $this->request->post();

	$renderer = Kostache_Layout::factory('Layout/Template');
	$this->response->body($renderer->render($view));
	}
	 
	public function action_logout() 
	{
		// Log user out
		Auth::instance()->logout();
		 
		// Redirect to login page
		$this->redirect('user/login');
	}
 
}
