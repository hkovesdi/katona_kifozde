@extends('layouts.nyomtatvanyok') 
@section('content')

        <div style="text-align: center;">
            <div><h3>{{$datum['datum']}}</h3></div>
            <div class="mt-1"><h3>{{$datum['het']}}. hét</h3></div>
            <div class="mt-2"><h3>{{Helper::getNapFromDayOfWeek($datum['nap'])}}</h3></div>
        </div>



<table class="szakacs-table table table-bordered mt-1">

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