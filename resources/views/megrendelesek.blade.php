@extends('app')
@section('content')

<div id="week-counter">
    @if((Auth::user()->munkakor != 'Kiszállító') || (Auth::user()->munkakor == 'Kiszállító' && ($ev > \Carbon\Carbon::now()->year || $het > \Carbon\Carbon::now()->weekOfYear)))
        <a class="baljobbgombA" href="/megrendelesek/{{$user->id}}/{{$het-1 === 0 ? $ev-1 : $ev}}-{{$het-1 === 0 ? 53 : $het-1}}">
            <button type="button" class="baljobbgomb arrows"><i class="fas fa-arrow-left"></i></button>
        </a>
    @endif
    <span id="het-text">{{$ev}} - {{$het}}. hét</span>
    @if($ev < \Carbon\Carbon::now()->year || $het <= \Carbon\Carbon::now()->weekOfYear)
        <a class="baljobbgombA" href="/megrendelesek/{{$user->id}}/{{$het+1 > 53 ? $ev+1 : $ev}}-{{$het+1 > 53 ? 1 : $het+1}}">
            <button type="button" class="baljobbgomb baljobbgombR arrows"><i class="fas fa-arrow-right"></i></button>
        </a>
    @endif
</div>

<div id="buttons">
    <button class="btn-basic" onclick="hozzaadasFunction()">Hozzáadás</button>
    @if(Auth::user()->munkakor != 'Kiszállító')
        <a class="btn-basic gomb" href="{{route('nyomtatvanyok.futarHeti', ['kiszallito' => $user, 'evHet' => $ev.'-'.$het])}}" style="">Futár heti</a>
    @endif
    @if (Request::get('name'))
    <div id="hozzaadas-btn">
    @else
    <div class="input-hide" id="hozzaadas-btn">
    @endif
        <div class="card">
            <div class="card-body">
                @if (Request::get('name'))
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
                                        <td>{{$searchedMegrendelo['kiszallito']['nev'] ?? '-'}}</td>
                                        @if(!$megrendeloHetek->pluck('megrendelo_id')->contains($searchedMegrendelo->id) && ($searchedMegrendelo['kiszallito']['id'] === null || Auth::user()->munkakor != 'Kiszállító'))
                                            <td>
                                                <form method="post" action="{{route('megrendeloHetLetrehozas', ['user' => $user,'megrendelo' => $searchedMegrendelo])}}">
                                                    @csrf
                                                    <input type="hidden" name="ev" value="{{ $ev }}">
                                                    <input type="hidden" name="het" value="{{ $het }}">
                                                    <input type="hidden" name="megrendelo-id" value="{{$searchedMegrendelo->id}}">
                                                    <button type="submit" class="btn btn-sm inner-hozzaadas-btn" style="box-shadow: none !important; width: 212px !important;">Hozzáadás</button>
                                                </form>
                                            </td>
                                        @elseif($searchedMegrendelo['kiszallito']['id'] !== $user->id)
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
        <x-megrendelok-het-table tartozas="0" :megrendeloHetek="$megrendeloHetek" :het="$het" :user="$user"/>
    </div>
@endif

<div class="tablazat-cim">
    Tartozások
</div>

@if($tartozasok->isEmpty())
    <h5 class="heti-ertesito"><i class="fas fa-check" style="color: green"></i> Nincsenek tartozások!</h5>
@else
    <div class="flex-center">
        <x-megrendelok-het-table tartozas="1" :megrendeloHetek="$tartozasok" :het="$het" :user="$user"/>
    </div>
@endif



<script>

    $(document).on('click', '.megrendeles-modal-button', function() {
        let modal = $($(this).data("target"));
        let megrendeloHetId = modal.data('megrendelo-het-id');
        let ajaxTarget = modal.find('.ajax-content');
        if(!ajaxTarget.hasClass('loaded')) {
            $.ajax({
                    type: "GET",
                    url: window.location.origin+'/megrendeles-table/'+megrendeloHetId,
                    statusCode: {
                        500: function() {
                                Toast.fire({
                                icon: 'error',
                                title: 'Váratlan hiba történt, kérem frissítse az oldalt és próbálja újra!'
                            });
                        }
                    },
                    success: function(data)
                    {
                        ajaxTarget.html(data);
                    },
                    error: function(data)
                    {
                        Toast.fire({
                            icon: 'error',
                            title: data.responseJSON.message
                        });
                    },
                });
        }
    });

    $(document).on('ajaxSuccess', '.fizetesi-status-modosito-form', function(event) {
        console.log(event)
        // Get ID
        let id = [...event.currentTarget[8].classList].find(classElem => classElem.startsWith('fizetve-button-id-')).split('-')[3]

        // Change values
        $(event.currentTarget[8]).toggleClass('fizetve-button-kifizetve');
        $(event.currentTarget[5]).prop('disabled', !$(event.currentTarget[5]).is(":disabled"));
        $(event.currentTarget[6]).val( $(event.currentTarget[6]).val() == 0 ? 1 : 0);

        // Set kedvezmeny to disabled megrendelo-het-id-614
        $('.megrendelo-het-id-' + id).prop('disabled', !$('.megrendelo-het-id-' + id).is(":disabled"));
    });

    let stateForKedvezmenyClick = -1;
    $('.kedvezmeny-input').focus(function(e){
        stateForKedvezmenyClick = e.currentTarget.value;
    });

    $('.kedvezmeny-input').blur(function(e){
        let megrendeloHetId = e.currentTarget.classList[1].split('-')[3];
        if(e.currentTarget.value !== stateForKedvezmenyClick) {
            document.rememberScroll();
            $(this.form).submit();
        }
    });

    $('.fizetve-modal').click(function(e) {
        let megrendeloId = [...e.currentTarget.classList].find(element => element.startsWith('fizetve-button-id')).split('-')[3];

        Swal.fire({
            title: 'Biztos benne?',
            text: "Ha a hetet fizetettre állítja akkor a hozzá tartozó tételek módosítására nem lesz lehetőség.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Igen',
            cancelButtonText: 'Mégse'
        }).then((result) => {
            if (result.value) {
                $('.form-id-' + megrendeloId).submit();
            }
        })
    });

    $(document).on('click','.megrendeles-modositas-button', function(e) {
        e.preventDefault();
        let megrendeloId = e.currentTarget.classList[3].split('-')[4];
        Swal.fire({
            title: 'Biztos benne, hogy módosítja a megrendeléseket?',
            text: 'Megrendeléseket utólag csak a főnök vagy a titkárnő tud kivenni',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Igen',
            cancelButtonText: 'Mégse'
        }).then((result) => {
            if (result.value) {
                $('.megrendeles-modositas-id-' + megrendeloId).submit();
            }
        });
    });

    $('.sortable-table').sortable({
        axis: "y",
        cancel: ".sortable-table tr span",
        distance: 2,
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index)
            {
            // Set helper cell sizes to match the original sizes
            $(this).width($originals.eq(index).outerWidth());
            });
            return $helper;
        },
        update: function( e, { item } ) {
            let domElements = Array.from($('.sortable-table')[0].children);
            let tableRows = [];
            domElements.forEach(data => {
                if (data.tagName === "TR") {
                    tableRows.push(data);
                }
            })

            let tableRowIds = tableRows.map(x => x.id.split('-')[1])
            let data = {
                ids: tableRowIds,
                ev: <?php echo $ev ?>,
                het: <?php echo $het ?>
            };

            $.ajax({
                type: "POST",
                url: window.location.origin+'/megrendelo-het-sorrend-modositas/'+<?php echo $user->id ?>,
                data: data,
                statusCode: {
                    500: function() {
                            Toast.fire({
                            icon: 'error',
                            title: 'Váratlan hiba történt'
                        });
                    }
                },
                success: function(data)
                {
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    //$( form ).trigger("ajaxSuccess", data);
                },
                error: function(data)
                {
                    Toast.fire({
                        icon: 'error',
                        title: data.responseJSON.message
                    });
                },
            });
        }
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