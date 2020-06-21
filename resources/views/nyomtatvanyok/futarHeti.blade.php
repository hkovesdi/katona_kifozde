@extends('layouts.nyomtatvanyok') 
@section('content')

<div style="text-align: center; mt-3">
    <div><h3>{{$ev}} - {{$het}}. hét</h3></div>
    <div><h3>{{$kiszallito->nev}}</h3></div>
</div>
<div>
    @if($megrendeloHetek->count() > 0)
    @foreach($megrendeloHetek->split(ceil(($megrendeloHetek->count()/18))) as $idx => $megrendeloHetekSplit)
    <div class="mt-2">
        <table class="futar-table table-sm table-striped" style="margin: auto">
            <thead class="futar-thead">
                <tr>
                    <th>Név</th>
                    <th>Fiz. mód</th>
                    <th>Összeg</th>
                </tr>
            </thead>

            <tbody class="futar-tbody">
                @foreach ($megrendeloHetekSplit as $megrendeloHet)
                    <tr>
                        <td>{{$megrendeloHet->megrendelo->nev}}</td>
                        <td>{{$megrendeloHet->fizetesi_mod}}</td>
                        <td>{{$megrendeloHet->osszeg}} Ft</td>
                    </tr>
                    
                @endforeach

            </tbody>
        </table>
    </div>
    <div style="page-break-after: always;"></div>
    @endforeach
    <div class="mt-2"  style="margin: auto">
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
        <h3 style="text-align: center;">Összesen: {{$megrendeloHetek->sum('osszeg')}} Ft</h3>
    </div>
    @endif
</div>
@stop