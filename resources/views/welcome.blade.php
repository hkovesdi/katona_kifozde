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
            <tr role="row">
                <td role="cell" class="centercell">
                    <button id="menusorbtn" class="btn-rend" data-toggle="modal" data-target="#megrendelo-1-modal">Menüsor</button>
                </td>
                <td role="cell" id="name">Katona Bence</td>
                <td role="cell">Cegléd, Csengeri szél 46.</td>
                <td role="cell">+36309737274</td>
                <td role="cell" class="centercell">
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

        </tbody>
    </table>

    <script>
        $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
        })
    </script>

    <div class="modal" tabindex="-1" role="dialog" id="megrendelo-1-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$het}}. hét | Katona Bence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <table id="myTable" class="megrendelo-table">
                        <tr>
                            <td style="width: 100px">{{$het}}. hét</td>
                            <td style="width: 50px">A</td>
                            <td style="width: 50px">B</td>
                            <td style="width: 50px">L</td>
                            <td style="width: 50px">A m</td>
                            <td style="width: 50px">B m</td>
                            <td style="width: 50px">T</td>
                            <td style="width: 50px">Dz</td>
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

                        <tr>
                            <td>Hétfő</td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
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

                        <tr>
                            <td>Kedd</td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
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

                        <tr>
                            <td>Szerda</td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
    {{--                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td> --}}
                        </tr>

                        <tr>
                            <td>Csütörtök</td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
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

                        <tr>
                            <td>Péntek</td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
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
         
                    </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="button" class="btn btn-primary">Mentés</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@stop