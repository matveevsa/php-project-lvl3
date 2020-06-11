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
        $domains = DB::table('domains')->get();
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

        $created_at = Carbon::now();
        $domain = [
            'name' => $domainName,
            'created_at' => $created_at
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
        return view('show', compact('domain'));
    }

    public function dump()
    {
        return view('dump');
    }
}
