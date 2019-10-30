<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Host;
use App\User;
use App\Relation;
use Auth;
use Redirect;

class HostController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$hosts = Host::orderBy('host_name', 'asc')->get();
		return view('hosts.index', compact('hosts'));
	}

	public function create(Host $host, Request $request)
	{
		$hosts = Host::orderBy('host_name', 'asc')->get();
		return view('hosts.create', compact('hosts'));
	}

	public function store(Request $request)
	{
		//validate input form
		$this->validate($request, [
			'host_name' => 'required|min:3',
			'host_definition' => 'required'
		]);

		//find user
		$user = User::find(Auth::user()->id);

		//create host
		$host = Host::create(['host_name' => $request->input('host_name'), 'host_definition' => $request->input('host_definition')]);

		//attach new host to user
		$user->hosts()->attach($host);

		//if object has been set, create relation
		if ($request->has('object_id')) {
			if ($request->input('object_id') <> 0) {
				$object = Host::where('id',$request->input('object_id'))->first();
				$host->relationship($object)->create(['relation_name' => 'has a relation to', 'relation_description' => 'has a relation to']);
			}
		}

		return Redirect::to('/hosts/')->with('message', 'Host created.');
	}

	public function edit(Host $host)
	{
		//check if id property exists
		if (!$host->id) {
			abort(403, 'This host no longer exists in the database.');
		}

		return view('hosts.edit', compact('host'));
	}

	public function update(Host $host, Request $request)
	{
		//validate input form
		$this->validate($request, [
			'host_name' => 'required|min:3',
			'host_definition' => 'required'
		]);

		$host->update($request->all());

		return Redirect::to('/hosts/')->with('message', 'Host updated.');
	}

	public function destroy(Host $host)
	{
		//check if id property exists
		if (!$host->id) {
			abort(403, 'This host no longer exists in the database.');
		}
		//delete host
		$host->delete();

		return Redirect::to('/hosts/')->with('message', 'Host deleted.');
	}
}
