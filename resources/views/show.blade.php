@extends('layouts.app')

@section('content')
@include('flash::message')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: https://{{ $domain->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
                                <tbody><tr>
                    <td>id</td>
                    <td>{{ $domain->id }}</td>
                </tr>
                                <tr>
                    <td>name</td>
                    <td>https://{{ $domain->name }}</td>
                </tr>
                                <tr>
                    <td>created_at</td>
                    <td>{{ $domain->created_at }}</td>
                </tr>
                                <tr>
                    <td>updated_at</td>
                    <td>{{ $domain->updated_at }}</td>
                </tr>
                        </tbody></table>
    </div>
    <h2 class="mt-5 mb-3">Checks</h2>
    <form method="post" action="https://php-l3-page-analyzer.herokuapp.com/domains/116/checks">
        <input type="hidden" name="_token" value="VjZnEDEhC5IO6XpOCMOhpielZXoBXK7P2fWmmKAi">            <input type="submit" class="btn btn-primary" value="Run check">
    </form>
                <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
                                <tbody><tr>
                    <td>200</td>
                    <td>2020-04-07 14:22:08</td>
                </tr>
                                <tr>
                    <td>200</td>
                    <td>2020-05-22 16:43:02</td>
                </tr>
                                <tr>
                    <td>200</td>
                    <td>2020-05-22 16:43:05</td>
                </tr>
                        </tbody></table>
        </div>
    </div>
    @endsection