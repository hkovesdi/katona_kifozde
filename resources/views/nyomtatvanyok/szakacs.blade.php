@extends('layouts.nyomtatvanyok') 
@section('content')

        <div style="text-align: center;">
            <div><h2>{{$datum['datum']}}</h2></div>
            <div class="mt-1"><h2>{{$datum['het']}}. hét</h2></div>
            <div class="mt-2"><h2>{{Helper::getNapFromDayOfWeek($datum['nap'])}}</h2></div>
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