<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DomainsController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')->get()->sort();
        return view('domains', compact('domains'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain.name' => 'required|url'
        ]);

        if ($validator->fails()) {
            flash('Not a valid url')->error()->important();
            return redirect()->route('domains.create');
        }

        $domainData = $request->input('domain');
        $domainName = parse_url($domainData['name'], PHP_URL_HOST);

        $currentId = DB::table('domains')
            ->where('name', $domainName)
            ->value('id');

        if (!empty($currentId)) {
            flash('Url already exists')->info()->important();
            return redirect()->route('domains.show', ['id' => $currentId]);
        }

        $domain = [
            'name' => $domainName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $newId = DB::table('domains')->insertGetId($domain);

        flash('Url has been added')->info()->important();
        return redirect()->route('domains.show', ['id' => $newId]);
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);

        if (empty($domain)) {
            return abort(404);
        }

        $domainChecks = DB::table('domain_checks')
            ->where('domain_id', '=', $domain->id)
            ->get()
            ->sortDesc();

        $domain->checks = $domainChecks;

        return view('show', compact('domain'));
    }

    public function checks($id)
    {
        $domain = DB::table('domains')->find($id);

        if (empty($domain)) {
            return abort(404);
        }

        $domainChecks = [
            'domain_id' => $domain->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('domains')
            ->where('id', '=', $domain->id)
            ->update(['updated_at' => Carbon::now()]);

        DB::table('domain_checks')
            ->insert($domainChecks);

        flash('Url has been checked')->info()->important();
        return redirect()->route('domains.show', $domain->id);
    }
}
