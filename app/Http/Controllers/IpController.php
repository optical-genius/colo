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
use Neo4jClient;

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

    public function testcypher()
    {
        $start = microtime(true);
        $memorylim = memory_get_usage() / 1024;
//        $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, h.host_name LIMIT 6000');
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN { id: ID(n), ip_name: n.ip_name }, collect(distinct { id: ID(h), host_name: h.host_name }) LIMIT 100');
      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, collect(distinct h.host_name) LIMIT 6000');
        //$records = $test->getRecords();
        $records = $test->getRecords();



        $vueRecordArray = [];
        foreach ($records as $vue){
            $vueRecordArray[] = $vue->values();
        }

        //dd($vueRecordArray);



        $vue = Neo4jClient::run('MATCH (n:Ip) RETURN n.ip_name LIMIT 100');
        $vueRecords = $vue->getRecords();
        $vueArray = [];
        foreach ($vueRecords as $vueRecord){
            $vueArray[] = $vueRecord->values()[0];
        }
        $jsonVue = $vueArray;


        return view('testcypher', compact('records', 'memorylim', 'start', 'vueRecordArray'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = microtime(true);


//        $testfake = Ip::testFake();


//       $user = User::find(Auth::user()->id);
//       $fake = Ip::ipFakerCreate();
//       $user->ips()->attach($fake);

//        $ip = Ip::find(4184);
//        $fake = Ip::hostFakerCreate();
//        $ip->objectHost()->attach($fake);


        /**
         * Выбираем из базы все ip
         * Находим связи для ip адреса
         * Если связи есть то ищем родителя в хостах
         *
         * $ip = Ip::find(31);
         * $rel = $ip->whichRelation()->first();
         * $host = $rel->object()->get();
         * $rel = $ip->whichRelation()->first()->object()->get();
         */

//        $ips = Ip::all();
//        $host = array();
//        foreach ($ips as $ip) {
//
//            $relations = $ip->whichRelation()->get();
//            if (empty($relations->first())) {
//                $host[] = array('ip_name' => $ip['ip_name'], 'ip_id' => $ip['id']);
//            } else {
//                foreach ($relations as $relation) {
//                    $hosts = $relation->object()->get();
//                    $host[] = array('ip_name' => $ip['ip_name'], 'ip_id' => $ip['id'], 'host_name' => $hosts->first()['host_name']);
//                }
//            }
//        }
//
//        $testhost = collect($host);
//        $grouped = $testhost->groupBy('ip_name');


        $grouped = Ip::with('host')->take(50)->get();
        $memorylim = memory_get_usage() / 1024;
        return view('ips.index', compact('grouped', 'start', 'memorylim'));

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
                $object = Ip::where('id', $request->input('object_id'))->first();
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
