<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class DomainsController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')
            ->join('domain_checks', 'domains.id', '=', 'domain_checks.domain_id', 'left outer')
            ->select('domains.*', 'domain_checks.status_code')
            ->get()
            ->unique('id')
            ->sort();

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

        $response = Http::get($domain->name);
        $bodyHtml = $response->body();

        $document = new Document($bodyHtml);

        $h1 = $document->has('h1') ? $document->first('h1')->text() : null;
        $keywords = $document->has('meta[name="keywords"]')
            ? $document->first('meta[name="keywords"]')->getAttribute('content')
             : null;
        $description = $document->has('meta[name="description"]')
            ? $document->first('meta[name="description"]')->getAttribute('content')
             : null;

        $domainChecks = [
            'domain_id' => $domain->id,
            'status_code' => $response->status(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'h1' => $h1,
            'keywords' => $keywords,
            'description' =>  $description
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
