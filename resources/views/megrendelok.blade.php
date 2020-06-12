@extends('app')

@section('content')
<div class="megrendelo-table-holder">
    <div style="max-width: 1200px; margin: 0 auto">
        <button style="margin-top: 15px" type="button" class="btn-basic button-helper" data-toggle="modal" data-target="#hozzaadasModal">Új megrendelő</button>
    </div>
    <div class="modal fade" id="hozzaadasModal" tabindex="-1" role="dialog" aria-labelledby="hozzaadasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hozzaadasModalLabel">Új megrendelő létrehozása</h5>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-primary" form="hozzaadas-form">Létrehozás</button>
                </div>
            </div>
        </div>
    </div>
    @if($megrendelok->count() > 0)
    <table class="main-table-megrendelo">
        <thead class="main-thead-megrendelo">
            <tr>
                <th class="fejlec-center row-nev">Név</th>
                <th class="fejlec-center row-cim">Cím</th>
                <th class="fejlec-center row-tel">Tel</th>
                <th style="width: 1%" class="fejlec-center">Szerkesztés</th>
            </tr>
        </thead>
        <tbody class="main-tbody-megrendelo">
            @foreach ($megrendelok as $megrendelo)
                <tr>
                    <td>{{$megrendelo->nev}}</td>
                    <td>{{$megrendelo->szallitasi_cim}}</td>
                    <td>{{$megrendelo->telefonszam}}</td>
                    <td valign="top" class="centercell">
                        <button type="button" style="box-shadow: none" class="btn-basic" data-toggle="modal" data-target="#szerkesztModal{{$megrendelo->id}}">
                            Szerkesztés
                        </button>
                    </td>
                    <div class="modal fade" id="szerkesztModal{{$megrendelo->id}}" tabindex="-1" role="dialog" aria-labelledby="szerkesztModalLabel{{$megrendelo->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="{{route('megrendeloModositas', $megrendelo->id)}}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="szerkesztModalLabel{{$megrendelo->id}}">{{$megrendelo->nev}} szerkesztése</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nevInput">Név</label>
                                            <input name="nev" type="text" class="form-control nevInput" value="{{$megrendelo->nev}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cimInput">Cím</label>
                                            <input name="cim" type="text" class="form-control cimInput" value="{{$megrendelo->szallitasi_cim}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="telInput">Telefonszám</label>
                                            <input name="tel" type="text" class="form-control telInput" value="{{$megrendelo->telefonszam}}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                                        <button type="submit" onclick="document.rememberScroll()" class="btn btn-primary">Mentés</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h1 class="heti-ertesito mt-3">Nincsenek megrendelők az adatbázisban</h1>
    @endif
</div>
@stop