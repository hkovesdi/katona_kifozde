@extends('layouts.nyomtatvanyokHTML') 
@section('content')

<div style="text-align: center; mt-3">
    <div><h3>{{$ev}} - {{$het}}. hét</h3></div>
    <div><h3>{{$kiszallito->nev}}</h3></div>
</div>
<div class="futar-heti-container mr-2 ml-2">
    @if($megrendeloHetek->count() > 0)
    @foreach($megrendeloHetek->split(ceil(($megrendeloHetek->count()/30))) as $idx => $megrendeloHetekSplit)
    <div class="mt-2" style="flex: 1;">
        <table class="futar-table table-sm table-striped">
            <thead class="futar-thead">
                <tr>
                    <th>Név</th>
                    <th>Fiz. mód</th>
                    <th>Összeg</th>
                    <th>Kedv.</th>
                </tr>
            </thead>

            <tbody class="futar-tbody">
                @foreach ($megrendeloHetekSplit as $megrendeloHet)
                    <tr>
                        <td>{{$megrendeloHet->megrendelo->nev}}</td>
                        <td>{{$megrendeloHet->fizetesi_mod}}</td>
                        <td>{{$megrendeloHet->osszeg}} Ft</td>
                        <td>{{$megrendeloHet->kedvezmeny}}%</td>
                    </tr>
                    
                @endforeach

            </tbody>
        </table>
    </div>
    @endforeach
</div>
    @if(ceil($megrendeloHetek->count()/30)%2 == 0 || ceil($megrendeloHetek->count()/30*30) - $megrendeloHetek->count() < 10)
        <div style="page-break-after: always !important"></div>
    @endif
    <div class="mt-2">
        <table class="futar-table table-sm table-striped" style="margin: 20px">
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
        <h3>Összesen: {{$megrendeloHetek->sum('osszeg')}} Ft</h3>
    </div>
    @endif
@stop