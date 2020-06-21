@extends('layouts.app')

@section('content')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: {{ $domain->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap bg-light">
            <tbody>
                <tr>
                    <td class="font-weight-bold w-25">id</td>
                    <td>{{ $domain->id }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">name</td>
                    <td>{{ $domain->name }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">created_at</td>
                    <td>{{ $domain->created_at }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">updated_at</td>
                    <td>{{ $domain->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h2 class="mt-5 mb-3">Checks</h2>
    <form method="post" action="{{ route('domains.checks', $domain->id) }}" class="mb-2">
        @csrf
        <input type="submit" class="btn btn-info" value="Run check">
    </form>
    @foreach ($domain->checks as $check)
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-light">
                <tbody>
                    <tr>
                        <td class="font-weight-bold w-25">id</td>
                        <td>{{ $check->id }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">status code</td>
                        <td>{{ $check->status_code }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">created_at</td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">updated_at</td>
                        <td>{{ $check->updated_at }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">h1</td>
                        <td>{{ $check->h1 }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">keywords</td>
                        <td>{{ $check->keywords }}</td>
                    </tr>
                    <tr>
                        <td  class="font-weight-bold">description</td>
                        <td>{{ $check->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
    </div>
    @endsection