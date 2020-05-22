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

        <p class="buttonrows">
            <button class="btn-basic">Hozzáadás</button>

            <button class="btn-basic">Módosítás</button>

            <button class="btn-basic">Törlés</button>
        </p>

    </div>
{{-- 
    <div>
        <table class="table table-sm table-dark table-responsive">
            <thead>
                <tr>
                    <th scope="col">Rendelések</th>
                    <th scope="col">Név</th>
                    <th scope="col">Cim</th>
                    <th scope="col">Tel</th>
                    <th scope="col">Fizetési mód</th>
                    <th scope="col">Összeg</th>
                    <th scope="col">Fizetett</th>
                </tr>
            </thead>

            <tbody>
                @foreach($megrendelok as $megrendelo)
                <tr role="row" id="megrendelo-{{$megrendelo['id']}}">
                    <th scope="row">
                        <button id="menusorbtn" class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$megrendelo['id']}}-modal">Menüsor</button>
                    </th>
                    <td name="nev">{{$megrendelo['nev']}}</td>
                    <td name="szallitasi-cim">{{$megrendelo['szallitasi_cim']}}</td>
                    <td name="telefonszam">{{$megrendelo['telefonszam']}}</td>
                    <td class="centercell" name="fizetesi-mod">
                        <select>
                            <option value="KP">Készpénz</option>
                            <option value="BK">Bankkártya</option>
                            <option value="SZK">Szépkártya</option>
                            <option value="BP">Baptista</option>
                        </select>
                    </td>
                    <td class="centercell">
                        15000Ft
                    </td>
                    <td class="centercell">
                        <button type="submit" class="fizetve-button">Fizetve</button>
                    </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div> --}}

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

                    <div class="table-responsive">
                    
                        <table id="megrendelo-{{$megrendelo['id']}}-table" class="megrendelo-table table-striped">
                            
                            <thead>
                                
                                <tr>
                                    
                                    <th class="megrendelo-thead" scope="col">{{$het}}. hét</td>
                                    
                                    @foreach($tetelek as $tetel)
                                    
                                    <th class="megrendelo-thead" scope="col" style="text-align: center">{{$tetel->nev}}</th>
                                
                                    @endforeach

                                </tr>

                            </thead>

                            <tbody>
                                
                                @foreach(array('Hétfő','Kedd','Szerda','Csütörtök','Péntek') as $idx => $nap)
                                    
                                <tr id="megrendelo-{{$megrendelo['id']}}-table-{{$nap}}" class="megrendelo-napok">
                                        
                                    <th scope="row">{{$nap}}</th>
                                    @foreach($tetelek as $tetelNev)
                                        @php
                                        $feladagCount=0;
                                        $normalAdagCount=0;
                                        if($megrendelo->megrendelesek != null) {
                                            $megrendelo->megrendelesek->each(function($megrendeles) use ($tetelNev,$idx,&$feladagCount,&$normalAdagCount){
                                                if(($megrendeles->tetel->datum->dayOfWeek == $idx+1) && ($megrendeles->tetel->tetel_nev == $tetelNev->nev)){
                                                    if($megrendeles->feladag){
                                                        $feladagCount++;
                                                    }
                                                    else {
                                                        $normalAdagCount++;
                                                    }
                                                }
                                            });
                                        }
                                        if($feladagCount > 0 && $normalAdagCount > 0){
                                            $rendelesValue = $normalAdagCount.'X'.$feladagCount.'F';
                                        }
                                        else if($feladagCount > 0){
                                            $rendelesValue = $feladagCount.'F';
                                        }
                                        else if($normalAdagCount > 0) {
                                            $rendelesValue = $normalAdagCount;
                                        }
                                        else {
                                            $rendelesValue = null;
                                        }
                                        @endphp
                                        <td>
                                            <input value="{{$rendelesValue}}" data-min-adag="{{$normalAdagCount}}" data-min-feladag="{{$feladagCount}}" id="megrendelo-{{$megrendelo['id']}}-table-{{$nap}}-input-{{$tetelNev->nev}}" class="megrendeles-table-input"></td>
                                    @endforeach

                                </tr>
                                
                                @endforeach

                            </tbody>

                        </table>
                    </div>

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

<script>
    $('.megrendelo-table tbody tr td .megrendeles-table-input').on('change', function() {
        
        if($(this).val() < $(this).attr('min')){
            $(this).val($(this).attr('min'));
        }
        if($(this).val() == 0){
            $(this).val("");
        }
    });
</script>
@stop