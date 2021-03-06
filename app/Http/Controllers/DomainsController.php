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
        $domains = DB::table('domains')
            ->get()
            ->sortBy('id');

        $domainChecks = DB::table('domain_checks')
            ->selectRaw('DISTINCT ON (domain_id) domain_id, status_code')
            ->orderBy('domain_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->keyBy('domain_id')
            ->toArray();

            return view('domains.domains', compact('domains', 'domainChecks'));
    }

    public function create()
    {
        return view('domains.create');
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

        $domainUrl = $request->input('domain');

        $urlParsed = parse_url($domainUrl['name']);

        $domainNormalizedName = strtolower("{$urlParsed['scheme']}://{$urlParsed['host']}");

        $currentId = DB::table('domains')
            ->where('name', $domainNormalizedName)
            ->value('id');

        if (!empty($currentId)) {
            flash('Url already exists')->info()->important();
            return redirect()->route('domains.show', ['id' => $currentId]);
        }

        $domain = [
            'name' => $domainNormalizedName,
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
            ->where('domain_id', $domain->id)
            ->get()
            ->sortDesc();

        $domain->checks = $domainChecks;

        return view('domains.show', compact('domain'));
    }
}
