@extends('app')
@section('content')

<div id="week-counter">
    @if((Auth::user()->munkakor != 'Kiszállító') || (Auth::user()->munkakor == 'Kiszállító' && $het > $currentHet))
        <a class="baljobbgombA" href="/megrendelesek/{{$user->id}}/{{$het-1 === 0 ? $ev-1 : $ev}}-{{$het-1 === 0 ? 53 : $het-1}}">
            <button type="button" class="baljobbgomb arrows"><i class="fas fa-arrow-left"></i></button>
        </a>
    @endif
    <span id="het-text">{{$ev}} - {{$het}}. hét</span>
    @if($het <= $currentHet)
        <a class="baljobbgombA" href="/megrendelesek/{{$user->id}}/{{$het+1 > 53 ? $ev+1 : $ev}}-{{$het+1 > 53 ? 1 : $het+1}}">
            <button type="button" class="baljobbgomb baljobbgombR arrows"><i class="fas fa-arrow-right"></i></button>
        </a>
    @endif
</div>

<div id="buttons">
    <button class="btn-basic" onclick="hozzaadasFunction()">Hozzáadás</button>
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
                                    <h5 class="modal-title" id="hozzaadasModalLabel">Új személy létrehozása</h5>
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
                                        <input type="hidden" name="ev" value="{{$ev}}">
                                        <input type="hidden" name="het" value="{{$het}}">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                                    <button type="submit" class="btn btn-primary" form="hozzaadas-form">Létrehozás</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-title">
                        "{{ Request::get('name') }}"
                    </div>
                    @if ($searchedMegrendelok && count($searchedMegrendelok) === 0)
                        <p>Ez a személy még nincs az adatbázisunkban </p>
                    @else
                        <table id="search-table">
                            <thead class="search-thead">
                                <tr>
                                    <th>Név</th>
                                    <th>Cim</th>
                                    <th>Tel</th>
                                    <th>Kiszállító</th>
                                    <th>Szerkesztés</th>
                                </tr>
                            </thead>
                            <tbody role="rowgroup" class="main-tbody">
                                @foreach($searchedMegrendelok as $searchedMegrendelo)
                                    <tr>
                                        <td>{{$searchedMegrendelo['nev']}}</td>
                                        <td>{{$searchedMegrendelo['szallitasi_cim']}}</td>
                                        <td>{{$searchedMegrendelo['telefonszam']}}</td>
                                        <td>{{$searchedMegrendelo->kiszallito['nev']}}</td>
                                        @if(!$megrendeloHetek->pluck('megrendelo_id')->contains($searchedMegrendelo->id) && $searchedMegrendelo->kiszallito_id == $user->id)
                                            <td>
                                                <form method="post" action="{{route('megrendeloHetLetrehozas', ['user' => $user,'megrendelo' => $searchedMegrendelo])}}">
                                                    @csrf
                                                    <input type="hidden" name="ev" value="{{ $ev }}">
                                                    <input type="hidden" name="het" value="{{ $het }}">
                                                    <input type="hidden" name="megrendelo-id" value="{{$searchedMegrendelo->id}}">
                                                    <button type="submit" class="btn btn-sm inner-hozzaadas-btn" style="box-shadow: none !important; width: 212px !important;">Hozzáadás</button>
                                                </form>
                                            </td>
                                        @elseif($searchedMegrendelo->kiszallito_id != $user->id)
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-success mobil-btn" disabled style="box-shadow: none !important; width: 212px !important;">Másik futárhoz tartozik</button>
                                            </td>
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-success mobil-btn" disabled style="box-shadow: none !important; width: 212px !important; ">Hozzáadva</button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <button type="button" class="btn btn-sm inner-hozzaadas-btn" data-toggle="modal" data-target="#hozzaadasModal">Új személy létrehozása</button>
                    <div id="new-search">Újabb keresés indítása:</div>
                @endif
                <div class="card-text">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" for="name" name="name" class="form-control" placeholder="Adja meg a kívánt nevet" style="width: 180px !important; ">
                        </div>
                        <button type="submit" id="search-btn" class="btn btn-sm">Keresés</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tablazat-cim">
    Heti megrendelések ({{$user->nev}})
</div>

@if($megrendeloHetek->isEmpty())
    <h5 class="heti-ertesito"><i class="fas fa-times" style="color: red"></i> A héten még nincsenek megrendelések!</h5>
@else
    <div class="flex-center">
        <x-megrendelok-het-table tartozas="0" :megrendeloHetek="$megrendeloHetek" :het="$het"/>
    </div>
@endif

<div class="tablazat-cim">
    Tartozások
</div>

@if($tartozasok->isEmpty())
    <h5 class="heti-ertesito"><i class="fas fa-check" style="color: green"></i> Nincsenek tartozások!</h5>
@else
    <div class="flex-center">
        <x-megrendelok-het-table tartozas="1" :megrendeloHetek="$tartozasok" :het="$het"/>
    </div>
@endif



<script>
    $(document).on('ajaxSuccess', '.fizetesi-status-modosito-form', function(event) {
        console.log(event);
        $(event.currentTarget[8]).toggleClass('fizetve-button-kifizetve');
        $(event.currentTarget[5]).prop('disabled', !$(event.currentTarget[5]).is(":disabled"));
        $(event.currentTarget[6]).val( $(event.currentTarget[6]).val() == 0 ? 1 : 0);
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

    $(document).on('change', '.megrendelo-table tbody tr td .megrendeles-table-input', function() {
        let val = $(this).val().trim();
        let re = /(^\d+)((?:x|X)|\s)?(\d+)?(f$|F$)?/g;
        let groups = re.exec(val);
        let validInputs = selectValidInputs(groups,val);
        console.log(validInputs);
        if(validInputs['err']){
            //invalid input notification
            $(this).val("");
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