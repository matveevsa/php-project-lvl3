<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/domains', function () {
    $domains = DB::table('domains')->get();
    return view('domains', ['domains' => $domains]);
})->name('domains.index');

Route::post('/domains', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'domain.name' => 'required|url'
    ]);

    if ($validator->fails()) {
        flash('Not a valid url')->error()->important();
        return redirect()->route('home');
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
})->name('domains.store');

Route::get('/domains/{id}', function($id) {
    $domain = DB::table('domains')->find($id);
    if (empty($domain)) {
        return abort(404);
    }
    return view('show', compact('domain'));
})->name('domains.show');