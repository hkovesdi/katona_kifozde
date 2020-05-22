<!DOCTYPE html>
@extends('app') 
@section('content')
<head>

    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
    {{-- Buttons --}}
    <div>

        <p id="week-counter">{{$het}}. hét</p>

        <button class="btn-basic">Hozzáadás</button>

        <button class="btn-basic">Módosítás</button>

        <button class="btn-basic">Törlés</button>

    </div>


    <div class="flex-center">
    <table role="table" class="main-table">
        <thead role="rowgroup" class="main-thead">
            <tr role="row">
                <th role="columnheader" class="fejlec-center row-rend">Rendelések</th>
                <th role="columnheader" class="fejlec-center row-nev">Név</th>
                <th role="columnheader" class="fejlec-center row-cim">Cim</th>
                <th role="columnheader" class="fejlec-center row-tel">Tel</th>
                <th role="columnheader" class="fejlec-center row-fizm">Fizetési mód</th>
                <th role="columnheader" class="fejlec-center row-ossz">Összeg</th>
                <th role="columnheader" class="fejlec-center row-fiz">Fizetett</th>
            </tr>
        </thead>
        <tbody role="rowgroup" class="main-tbody">

            @foreach($megrendelok as $megrendelo)
                <tr role="row" id="megrendelo-{{$megrendelo['id']}}">
                    <td role="cell" class="centercell">
                        <button id="menusorbtn" class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$megrendelo['id']}}-modal">Menüsor</button>
                    </td>
                    <td role="cell" name="nev">{{$megrendelo['nev']}}</td>
                    <td role="cell" name="szallitasi-cim">{{$megrendelo['szallitasi_cim']}}</td>
                    <td role="cell" name="telefonszam">{{$megrendelo['telefonszam']}}</td>
                    <td role="cell" class="centercell" name="fizetesi-mod">
                        <select>
                            <option value="KP">Készpénz</option>
                            <option value="BK">Bankkártya</option>
                            <option value="SZK">Szépkártya</option>
                            <option value="BP">Baptista</option>
                        </select>
                    </td>
                    <td role="cell" class="centercell">
                        15000Ft
                    </td>
                    <td role="cell" class="centercell">
                        <button type="submit" class="fizetve-button">Fizetve</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <script>
        $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
        })
    </script>

    @foreach($megrendelok as $megrendelo)
    <div class="modal" tabindex="-1" role="dialog" id="megrendelo-{{$megrendelo['id']}}-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$megrendelo['nev']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <table id="megrendelo-{{$megrendelo['id']}}-table" class="megrendelo-table">
                        <tr>
                            <th style="width: 100px">{{$het}}. hét</td>
                            @foreach($tetelek as $tetel)
                                <th style="width: 50px">{{$tetel->nev}}</th>
                            @endforeach
    {{--                         <td>A1</td>
                            <td>A2</td>
                            <td>A3</td>
                            <td>A4</td>
                            <td>A5</td>
                            <td>S1</td>
                            <td>S2</td>
                            <td>S3</td>
                            <td>S4</td> --}}
                        </tr>

                        @foreach(array('Hétfő','Kedd','Szerda','Csütörtök','Péntek') as $nap)
                            <tr id="megrendelo-{{$megrendelo['id']}}-table-{{$nap}}">
                                <th>{{$nap}}</th>
                                @foreach($tetelek as $tetel)
                                    <td><input type="number" id="megrendelo-{{$megrendelo['id']}}-table-{{$nap}}-input-{{$tetel->nev}}" class="megrendeles-table-input"></td>
                                @endforeach
        {{--                         <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> --}}
                            </tr>
                        @endforeach
         
                    </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="button" class="btn btn-primary">Mentés</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
@stop