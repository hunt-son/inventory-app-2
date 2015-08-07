<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return View::make('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
        $validator = Validator::make($data = Input::all(), User::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $user = new User;
        $user->username = $data['username'];
        $user->password = Hash::make($data['username']);
        $user->email = $data['email'];
        $user->save();
        Flash::success('You have Created a New User!');
        Redirect::To('/');
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();

        $user = User::where('id', $data['id'])->first();
        dd($user->password);
        $data['current'] = Hash::make("'".$data['old']."'");
        if ($user->password != $data['current']) {}

        User::create($data);
        Flash::success('You have created a new user!');
        return Redirect::back();
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);
		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return View::make('users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$user->update($data);

		return Redirect::route('users.index');
	}

    public function controlRole() {
        $data = Input::all();
        $id = $data['id'];
        $user = User::where('id','=', $id)->first();
        if ($user->hasRole('Owner')) {
            $user['role'] = 'Owner';
        }
        elseif ($user->hasRole('Member')) {
            $user['role'] = 'Member';
        }
        else $user['role'] = 'None';
        return $user;
    }

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy()
    {
        Auth::logout();
        return Redirect::to('/login');
    }

}
