@extends('app') 
@section('content')

    <h2 class="datum flex-center">
            
        datum tól ig
        hét 


    </h2>

<div class="flex-container flex-center">
    <table class="futar-table table table-bordered">
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

    <table class="futar-table table table-bordered">
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

    <table class="futar-table table table-bordered">
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