@extends('app') 
@section('content')

    <h2 class="datum flex-center">
        
        {{$datum['datum']}}
        {{$datum['het']}}. hét
        {{$datum['nap']}}

    </h2>

<table class="szakacs-table table table-bordered">

    <thead class="szakacs-thead">
        <tr>
            <th>
                Menü
            </th>
            <th>
                Adag
            </th>
        </tr>
    </thead>

    <tbody>
        
            @foreach ($tetelek as $tetel)
                <tr>

                    <td scope="col">
                        {{$tetel->nev}}
                    </td>

                    <td scope="col">
                        {{$tetel->darab}} db
                    </td>

                </tr>
            @endforeach
        
    </tbody>

</table>

@stop