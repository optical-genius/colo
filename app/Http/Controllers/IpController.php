<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ip;
use App\Host;
use App\User;
use App\Relation;
use Auth;
use Redirect;
use Vinelab\NeoEloquent\Eloquent\Edges\EdgeIn;

class IpController extends Controller
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
        $ip = Ip::find(31);
        $relation = $ip->hosts()->get();
        dd($relation);
       // $rel = $ip->whichRelation()->first();

       // $rela = Relation::find(41);

       // $host = $rela->subject()->get();
       // dd($host);


        $ips = Ip::orderBy('ip_name', 'asc')->get();




        return view('ips.index', compact('ips'));

	}

	public function create(Ip $ip, Request $request)
	{
        $ips = Ip::orderBy('ip_name', 'asc')->get();
		return view('ips.create', compact('ips'));
	}

	public function store(Request $request)
	{
		//validate input form
		$this->validate($request, [
			'ip_name' => 'required|min:3',
		]);

		//find user
		$user = User::find(Auth::user()->id);

		//create host
		$ip = Ip::create(['ip_name' => $request->input('ip_name')]);

		//attach new host to user
		$user->ips()->attach($ip);

		//if object has been set, create relation
		if ($request->has('object_id')) {
			if ($request->input('object_id') <> 0) {
				$object = Ip::where('id',$request->input('object_id'))->first();
				$host->relationship($object)->create(['relation_name' => 'has a relation to', 'relation_description' => 'has a relation to']);
			}
		}

		return Redirect::to('/ips/')->with('message', 'Ip created.');
	}

	public function edit(Ip $ip)
	{
		//check if id property exists
		if (!$ip->id) {
			abort(403, 'This host no longer exists in the database.');
		}

		return view('ips.edit', compact('ip'));
	}

	public function update(Ip $ip, Request $request)
	{
		//validate input form
		$this->validate($request, [
			'ip_name' => 'required|min:3',
		]);

		$ip->update($request->all());

		return Redirect::to('/ips/')->with('message', 'Host updated.');
	}

	public function destroy(Ip $ip)
	{
		//check if id property exists
		if (!$ip->id) {
			abort(403, 'This host no longer exists in the database.');
		}
		//delete host
        //dd($host->relationship($host)->detach());
        $ip->relationship($ip)->detach();

		$ip->delete();



		return Redirect::to('/ips/')->with('message', 'Host deleted.');
	}
}
