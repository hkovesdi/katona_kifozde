@extends('app')

@section('content')

@if($megrendelok->count() > 0)
<div class="megrendelo-table-holder">
    <table class="main-table-megrendelo">
        <thead class="main-thead-megrendelo">
            <tr>
                <th class="fejlec-center row-nev">Név</th>
                <th class="fejlec-center row-cim">Cím</th>
                <th class="fejlec-center row-tel">Tel</th>
                <th class="fejlec-center">Szerkesztés</th>
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
                                            <input name="nev" type="text" class="form-control" value="{{$megrendelo->nev}}" id="nevInput">
                                        </div>
                                        <div class="form-group">
                                            <label for="cimInput">Cím</label>
                                            <input name="cim" type="text" class="form-control" value="{{$megrendelo->szallitasi_cim}}" id="cimInput">
                                        </div>
                                        <div class="form-group">
                                            <label for="telInput">Telefonszám</label>
                                            <input name="tel" type="text" class="form-control" value="{{$megrendelo->telefonszam}}" id="telInput">
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
</div>
@else
    <h1 class="heti-ertesito mt-3">Nincsenek megrendelők az adatbázisban</h1>
@endif

@stop