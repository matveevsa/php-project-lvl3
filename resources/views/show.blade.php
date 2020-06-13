@extends('layouts.app')

@section('content')
@include('flash::message')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: https://{{ $domain->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tbody>
                <tr>
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
            </tbody>
        </table>
    </div>
    <h2 class="mt-5 mb-3">Checks</h2>
    <form method="post" action="{{ route('domains.checks', $domain->id) }}" class="mb-2">
        @csrf
        <input type="submit" class="btn btn-primary" value="Run check">
    </form>
    @foreach ($domain->checks as $check)
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td class="font-weight-bold">id</td>
                        <td>{{ $check->id }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">created_at</td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">updated_at</td>
                        <td>{{ $check->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
    </div>
    @endsection