@extends('app') 
@section('content')

    {{-- Buttons --}}
    <div>

        <p id="week-counter">{{$ev}} - {{$het}}. hét</p>

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
                <tr role="row" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}">
                    <th scope="row">
                        <button id="menusorbtn" class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$megrendeloHet->megrendelo['id']}}-modal">Menüsor</button>
                    </th>
                    <td name="nev">{{$megrendeloHet->megrendelo['nev']}}</td>
                    <td name="szallitasi-cim">{{$megrendeloHet->megrendelo['szallitasi_cim']}}</td>
                    <td name="telefonszam">{{$megrendeloHet->megrendelo['telefonszam']}}</td>
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
    
                @foreach($megrendeloHetek as $megrendeloHet)
                    
                <tr role="row" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}">
                        
                    <td role="cell" class="centercell">
                        <button id="menusorbtn" class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$megrendeloHet->megrendelo['id']}}-modal">Menüsor</button>
                    </td>
                    
                    <td role="cell" name="nev">{{$megrendeloHet->megrendelo['nev']}}</td>
                    
                    <td role="cell" name="szallitasi-cim">{{$megrendeloHet->megrendelo['szallitasi_cim']}}</td>
                    
                    <td role="cell" name="telefonszam">{{$megrendeloHet->megrendelo['telefonszam']}}</td>
                    
                    <td role="cell" class="centercell" name="fizetesi-mod">
                        <select>
                            @foreach($fizetesiModok as $fizetesiMod)
                                <option {{$fizetesiMod->nev == "Készpénz" ? "selected" : ""}} value="{{$fizetesiMod->nev}}">{{$fizetesiMod->nev}}</option>
                            @endforeach
                        </select>
                    </td>

                    <td role="cell" class="centercell">
                        {{$megrendeloHet->osszeg + $megrendeloHet->tartozas}} Ft
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

        $(document).on('ajaxSuccess', '.megrendeles-modositas-form', function(){
            console.log('ajax success');
        });
    </script>

    @foreach($megrendeloHetek as $megrendeloHet)
    
    <div class="modal" tabindex="-1" role="dialog" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-modal">
        
        <div class="modal-dialog modal-lg" role="document">
            
            <div class="modal-content">
                
                <div class="modal-header">
                    
                    <h5 class="modal-title">{{$megrendeloHet->megrendelo['nev']}}</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>

                </div>
                <form action="{{route('megrendelesModositas')}}" method="post" class="megrendeles-modositas-form ajax">
                    @csrf
                <div class="modal-body" style="text-align: center">

                    <div class="table-responsive">
                    
                        <table id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table" class="megrendelo-table table-striped">
                            
                            <thead>
                                
                                <tr>
                                    
                                    <th class="megrendelo-thead" scope="col">{{$het}}. hét</td>
                                    
                                    @foreach($tetelek as $tetel)
                                    
                                    <th class="megrendelo-thead" scope="col" style="text-align: center">{{$tetel->nev}}</th>
                                
                                    @endforeach

                                </tr>

                            </thead>

                            <tbody>
                                    <input type="hidden" name="megrendelo-id" value="{{$megrendeloHet->megrendelo['id']}}">
                                    <input type="hidden" name="megrendelo-het-id" value="{{$megrendeloHet->id}}">

                                    @foreach(array('Hétfő','Kedd','Szerda','Csütörtök','Péntek') as $idx => $nap)
                                        
                                    <tr id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table-{{$nap}}" class="megrendelo-napok">
                                        {{-- <input type="hidden" name="megrendelesek[]" value="{{$idx}}"> --}}
                                            
                                        <th scope="row">{{$nap}}</th>
                                        @foreach($tetelek as $tetelIdx => $tetelNev)
                                            {{--  <input type="hidden" name="megrendelesek[{{$idx}}][]" value="{{$tetelIdx}}"> --}}
                                            @php
                                            $feladagCount=0;
                                            $normalAdagCount=0;
                                            if($megrendeloHet->megrendelesek != null) {
                                                $megrendeloHet->megrendelesek->each(function($megrendeles) use ($tetelNev,$idx,&$feladagCount,&$normalAdagCount){
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
                                                $rendelesValue = $normalAdagCount.'x'.$feladagCount.'F';
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
                                                <input type="hidden" class="normal-adag-input" value={{$normalAdagCount}} name="megrendelesek[{{$idx}}][{{$tetelNev->nev}}][normal]">
                                                <input type="hidden" class="feladag-input" value={{$feladagCount}} name="megrendelesek[{{$idx}}][{{$tetelNev->nev}}][fel]">
                                                <input value="{{$rendelesValue}}" data-min-adag="{{$normalAdagCount}}" data-min-feladag="{{$feladagCount}}" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table-{{$nap}}-input-{{$tetelNev->nev}}" class="megrendeles-table-input">
                                            </td>
                                        @endforeach

                                    </tr>
                                    
                                    @endforeach
                            </tbody>

                        </table>
                    </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <input type="submit" class="btn btn-primary megrendeles-modositas-button" value="Mentés">
                    </div>
                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

<script>
    $('.megrendeles-modositas-button').on('click', function(){
        //console.log($(this).closest('.modal').find('.megrendeles-modositas-form'));
       // $(this).closest('.modal').find('.megrendeles-modositas-form').submit();
    });

    function selectValidInputs(inp, ref) {
        let ret = {'normal' : 0, 'fel': 0, 'err':false};
        console.log(inp);
        if(inp == null || inp[0] !== ref){
            ret['err']=true;
        }
        else if(inp[2] !== undefined){
            console.log("X")
             if(inp[1] !== undefined && inp[3] !== undefined){
                 ret['normal'] = inp[1];
                 ret['fel'] = inp[3];
             }
             else {
                 ret['err'] = true;
             }
        }
        else if(inp[4] !== undefined) {
            console.log("F");
            ret['fel'] = inp[1];
        }
        else {
            ret['normal'] = inp[1];
        }

        return ret;
        
    }

    $('.megrendelo-table tbody tr td .megrendeles-table-input').on('change', function() {
        let val = $(this).val().trim();
        let re = /(^\d+)((?:x|X)|\s)?(\d+)?(f$|F$)?/g;
        let groups = re.exec(val);
        let validInputs = selectValidInputs(groups,val);
        console.log(validInputs);
        if(validInputs['err']){
            $(this).val(JSON.parse(<?php echo json_encode($rendelesValue) ?>));
            //invalid input notification
        }
        else {
            //console.log( $(this).siblings(".normal-adag-input"));
            $(this).siblings('.normal-adag-input').val(validInputs['normal']);
            $(this).siblings('.feladag-input').val(validInputs['fel']);
        }
    });
</script>
@stop