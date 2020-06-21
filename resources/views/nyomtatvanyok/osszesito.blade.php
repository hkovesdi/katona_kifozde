@extends('layouts.nyomtatvanyok') 
@section('content')

<div style="text-align: center;">
    <div><h3>Összesítő</h3></div>
    <div class="mt-1"><h3>{{$kezdete}} - {{$vege}}</h3></div>
</div>

<table class="osszesito-table table table-bordered mt-1">

    <thead class="osszesito-thead">
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
        
            @foreach ($megrendelesek as $tetelNev => $megrendeles)
                <tr>

                    <td scope="col">
                        {{$tetelNev}}
                    </td>

                    <td scope="col">
                        {{$megrendeles->count()}} db
                    </td>

                </tr>
            @endforeach
        
    </tbody>

</table>
<div style="page-break-after: always"></div>
<div class="mt-2">
    <table class="futar-table table-sm table-striped" style="margin: 20px auto">
        <thead class="futar-thead">
            <tr>
                <th>Fizetési mód</th>
                <th>Összeg</th>
            </tr>
        </thead>

        <tbody class="futar-tbody">
            @foreach ($fizetesiModok as $fizetesiMod)
                <tr>
                    <td>{{$fizetesiMod->nev}}</td>
                    <td> {{$fizetesiMod->osszeg}} Ft</td>
                </tr>
                
            @endforeach
        </tbody>
    </table>
    <h3 style="text-align: center;">Összesen: {{$osszeg}} Ft</h3>
</div>

@stop