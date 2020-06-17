@extends('layouts.nyomtatvanyok') 
@section('content')

<div style="text-align: center;">
    <div><h3>2020 - 12. hét</h3></div>
</div>
<div>
    <table class="futar-table table-sm table-bordered table-striped" style="float: left;">
        <thead class="futar-thead">
            <tr>
                <th>Név</th>
                <th>Fiz. mód</th>
                <th>Összeg</th>
            </tr>
        </thead>

        <tbody class="futar-tbody">
            @foreach ($megrendelok as $megrendelo)
                
                <tr>
                    <td>{{$megrendelo['nev']}}</td>
                    <td>{{$megrendelo['fizmod']}}</td>
                    <td>{{$megrendelo['osszeg']}}</td>
                </tr>
                
            @endforeach

        </tbody>
    </table>

    <table class="futar-table table-sm table-bordered table-striped" style="float: right;">
        <thead class="futar-thead">
            <tr>
                <th>Név</th>
                <th>Fiz. mód</th>
                <th>Összeg</th>
            </tr>
        </thead>

        <tbody class="futar-tbody">
            @foreach ($megrendelok as $megrendelo)
                
                <tr>
                    <td>{{$megrendelo['nev']}}</td>
                    <td>{{$megrendelo['fizmod']}}</td>
                    <td>{{$megrendelo['osszeg']}}</td>
                </tr>
                
            @endforeach

        </tbody>
    </table>
</div>
@stop