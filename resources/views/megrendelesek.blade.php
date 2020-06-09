@extends('app')
@section('content')

<div id="week-counter">
    @if((Auth::user()->munkakor != 'Kiszállító') || (Auth::user()->munkakor == 'Kiszállító' && $het > $currentHet))
    <a style="display:inline-block" href="/megrendelesek/{{$het-1 === 0 ? $ev-1 : $ev}}-{{$het-1 === 0 ? 53 : $het-1}}">
        <button type="button" class="btn-basic"><</button>
    </a>
    @endif
    <span>{{$ev}} - {{$het}}. hét</span>
    <a style="display:inline-block" href="/megrendelesek/{{$het+1 > 53 ? $ev+1 : $ev}}-{{$het+1 > 53 ? 1 : $het+1}}">
        <button type="button" class="btn-basic">></button>
    </a>
</div>

<div id="buttons">
    <button class="btn-basic" onclick="hozzaadasFunction()">Hozzáadás</button>
    <button class="btn-basic">Törlés</button>
    @if (Request::get('name'))
    <div id="hozzaadas-btn">
    @else
    <div class="input-hide" id="hozzaadas-btn">
    @endif
        <div class="card">
            <div class="card-body">
                @if (Request::get('name'))
                    <div class="modal fade" id="hozzaadasModal" tabindex="-1" role="dialog" aria-labelledby="hozzaadasModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hozzaadasModalLabel">Új személy hozzáadása</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="hozzaadas-form" action="{{route('megrendeloLetrehozas')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nev-hozzaadas" class="col-form-label">Név</label>
                                            <input name="nev" type="text" class="form-control" id="nev-hozzaadas" value="{{ Request::get('name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cim-hozzaadas" class="col-form-label">Cím</label>
                                            <input name="cim" type="text" class="form-control" id="cim-hozzaadas">
                                        </div>
                                        <div class="form-group">
                                            <label for="tel-hozzaadas" class="col-form-label">Telefonszám</label>
                                            <input name="tel" type="text" class="form-control" id="tel-hozzaadas">
                                        </div>
                                        @if (Auth::user()->munkakor == "Bo$$")
                                        <div class="form-group">
                                            <label for="kiszallito-hozzaadas">Kiszállító</label>
                                            <select name="kiszallito-id" class="form-control" id="kiszallito-hozzaadas">
                                                @foreach ($kiszallitok as $kiszallito)
                                                    <option value="{{$kiszallito->id}}">{{$kiszallito->nev}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-check">
                                            <input name="hozzaadas" class="form-check-input" type="checkbox" id="hozzaadas-hethez-check">
                                            <label class="form-check-label" for="hozzaadas-hethez-check">Hozzáadás a héthez</label>
                                        </div>
                                        <input type="hidden" name="ev" value="{{$ev}}">
                                        <input type="hidden" name="het" value="{{$het}}">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                                    <button type="submit" class="btn btn-primary" form="hozzaadas-form">Hozzáadás</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-title">
                        {{ Request::get('name') }}
                    </div>
                    @if ($searchedMegrendelok && count($searchedMegrendelok) === 0)
                        <p>Ez a személy még nincs az adatbázisunkban.</p>
                    @else
                        <table id="search-table">
                            <thead>
                                <tr>
                                    <th>Név</th>
                                    <th>Cim</th>
                                    <th>Tel</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody role="rowgroup" class="main-tbody">
                                @foreach($searchedMegrendelok as $searchedMegrendelo)
                                    <tr>
                                        <td>{{$searchedMegrendelo['nev']}}</td>
                                        <td>{{$searchedMegrendelo['szallitasi_cim']}}</td>
                                        <td>{{$searchedMegrendelo['telefonszam']}}</td>
                                        @if(!$megrendeloHetek->pluck('megrendelo_id')->contains($searchedMegrendelo->id))
                                            <td>
                                                <form method="post" action="{{route('megrendeloHetLetrehozas')}}">
                                                    @csrf
                                                    <input type="hidden" name="ev" value="{{ $ev }}">
                                                    <input type="hidden" name="het" value="{{ $het }}">
                                                    <input type="hidden" name="megrendelo-id" value="{{$searchedMegrendelo->id}}">
                                                    <button type="submit" class="btn btn-sm inner-hozzaadas-btn" style="box-shadow: none !important;">Hozzáadás</button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-success" disabled style="box-shadow: none !important;">Hozzáadva</button>
                                            </td>
                                        @endif 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <button type="button" class="btn btn-sm inner-hozzaadas-btn" data-toggle="modal" data-target="#hozzaadasModal">Új személy hozzáadása</button>
                    <div id="new-search">Újabb keresés indítása:</div>
                @endif
                <div class="card-text">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" for="name" name="name" class="form-control" placeholder="Adja meg a kívánt nevet">
                        </div>
                        <button type="submit" id="search-btn" class="btn btn-sm">Keresés</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

            @foreach($megrendeloHetek as $megrendeloHet)
                <form class="ajax fizetesi-status-modosito-form" method="post" action="{{route('fizetesiStatuszModositas', $megrendeloHet)}}">
                    @csrf
                    <tr role="row" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}">
                        <td role="cell" class="centercell">
                            <button class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$megrendeloHet->megrendelo['id']}}-modal" type="button">Menüsor</button>
                        </td>
                        <td role="cell" name="nev">{{$megrendeloHet->megrendelo['nev']}}</td>
                        <td role="cell" name="szallitasi-cim">{{$megrendeloHet->megrendelo['szallitasi_cim']}}</td>
                        <td role="cell" name="telefonszam">{{$megrendeloHet->megrendelo['telefonszam']}}</td>
                        <td role="cell" class="centercell" name="fizetesi-mod">
                            @if ($megrendeloHet->fizetve_at === null)
                                <select name="fizetesi-mod">
                            @else
                                <select name="fizetesi-mod" disabled>
                            @endif
                                @foreach($fizetesiModok as $fizetesiMod)
                                    @if ($megrendeloHet->fizetesi_mod == 'Tartozás')
                                        <option {{$fizetesiMod->nev == 'Készpénz' ? "selected" : ""}} value="{{$fizetesiMod->nev}}">{{$fizetesiMod->nev}}</option>
                                    @else
                                        <option {{$fizetesiMod->nev == $megrendeloHet->fizetesi_mod ? "selected" : ""}} value="{{$fizetesiMod->nev}}">{{$fizetesiMod->nev}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td role="cell" class="centercell">
                            {{$megrendeloHet->osszeg}} Ft
                        </td>
                        <td role="cell" class="centercell">
                                <input type="hidden" name="torles" value="{{ $megrendeloHet['fizetve_at'] !== null ? 1 : 0 }}">
                                <input type="hidden" name="megrendelo-het-id" value="{{ $megrendeloHet['id'] }}">
                                @if ($megrendeloHet['fizetve_at'] !== null)
                                    <button type="submit" class="fizetve-button-kifizetve fizetve-button ">Fizetve</button>
                                @else
                                    <button type="submit" class="fizetve-button">Fizetve</button>
                                @endif
                        </td>
                    </tr>
                </form>
            @endforeach
        </tbody>
    </table>

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
                        <div class="modal-body">
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
                                        @foreach($megrendeloHet->megrendeles_tablazat as $dayOfWeek => $megrendelesekPerNap)
                                            <tr id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table-{{$dayOfWeek}}" class="megrendelo-napok">
                                                {{-- <input type="hidden" name="megrendelesek[]" value="{{$idx}}"> --}}
                                                <th scope="row">{{Helper::getNapFromDayOfWeek($dayOfWeek)}}</th>
                                                @foreach($megrendelesekPerNap as $tetelNev => $megrendelesPerNap)
                                                    {{--  <input type="hidden" name="megrendelesek[{{$idx}}][]" value="{{$tetelIdx}}"> --}}
                                                    <td>
                                                        <input type="hidden" class="normal-adag-input" value={{$megrendelesPerNap['egesz']}} name="megrendelesek[{{$dayOfWeek-1}}][{{$tetelNev}}][normal]">
                                                        <input type="hidden" class="feladag-input" value={{$megrendelesPerNap['fel']}} name="megrendelesek[{{$dayOfWeek-1}}][{{$tetelNev}}][fel]">
                                                        <input value="{{Helper::adagokToString($megrendelesPerNap['egesz'], $megrendelesPerNap['fel'])}}" data-min-adag="{{$megrendelesPerNap['egesz']}}" data-min-feladag="{{$megrendelesPerNap['fel']}}" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table-{{$dayOfWeek}}-input-{{$tetelNev}}" class="megrendeles-table-input">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="megrendelo-megjegyzes">
                                    <h4 style="text-align: left">Megjegyzés</h4>
                                    <div style="width: 100%">
                                        <textarea name="" class="megrendelo-textarea"></textarea>
                                    </div>
                                </div>
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
    $(document).on('ajaxSuccess', '.fizetesi-status-modosito-form', function(event) {
        $(event.currentTarget[5]).toggleClass('fizetve-button-kifizetve');
        $(event.currentTarget[2]).prop('disabled', !$(event.currentTarget[2]).is(":disabled"));
        $(event.currentTarget[3]).val( $(event.currentTarget[3]).val() == 0 ? 1 : 0);
    });
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
            $(this).val(JSON.parse(<?php echo json_encode(Helper::adagokToString($megrendelesPerNap['egesz'], $megrendelesPerNap['fel'])) ?>));
            //invalid input notification
        }
        else {
            //console.log( $(this).siblings(".normal-adag-input"));
            $(this).siblings('.normal-adag-input').val(validInputs['normal']);
            $(this).siblings('.feladag-input').val(validInputs['fel']);
        }
    });

    function hozzaadasFunction() {
        $('#hozzaadas-btn').toggleClass('input-hide');
    }
</script>
@stop