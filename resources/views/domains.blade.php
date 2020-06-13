@extends('layouts.app')

@section('content')
@include('flash::message')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Domains</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tbody>
                <tr class="thead-light">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last check</th>
                    <th>Status Code</th>
                </tr>
                @foreach($domains as $domain)
                <tr>
                    <td>{{ $domain->id }}</td>
                    <td><a href="{{ route('domains.show', $domain->id) }}">https://{{ $domain->name }}</a></td>
                    <td>{{ $domain->updated_at }}</td>
                    <td></td>
                </tr>
                @endforeach
           </tbody>
        </table>
    </div>
</div>
@endsection