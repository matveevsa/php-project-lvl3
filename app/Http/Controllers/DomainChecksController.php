<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class DomainChecksController extends Controller
{

    public function store($id)
    {
        $domain = DB::table('domains')->find($id);

        if (empty($domain)) {
            return abort(404);
        }

        try {
            $response = Http::get($domain->name);
        } catch (\Exception $e) {
            flash('Url address has not exists')->error()->important();
            return redirect()->route('domains.show', $domain->id);
        }

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
            ->where('id', $domain->id)
            ->update(['updated_at' => Carbon::now()]);

        DB::table('domain_checks')
            ->insert($domainChecks);

        flash('Url has been checked')->info()->important();
        return redirect()->route('domains.show', $domain->id);
    }
}
