<form action="{{route('megrendelesModositas')}}" method="post" class="megrendeles-modositas-form megrendeles-modositas-id-{{$megrendeloHet->id}}">
    @csrf
    <div class="modal-body">
        <div class="table-responsive">
            <table id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table" class="megrendelo-table table-striped">
                <thead>
                    <tr>
                        <th class="megrendelo-thead" scope="col">{{$megrendeloHet['datum']['het']}}. hét</td>
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
                                    <input {{$tartozas == true ? 'disabled' : ''}} value="{{Helper::adagokToString($megrendelesPerNap['egesz'], $megrendelesPerNap['fel'])}}" data-min-adag="{{$megrendelesPerNap['egesz']}}" data-min-feladag="{{$megrendelesPerNap['fel']}}" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-table-{{$dayOfWeek}}-input-{{$tetelNev}}" class="megrendeles-table-input">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="megrendelo-megjegyzes">
                <h4 style="text-align: left">Megjegyzés</h4>
                <div style="width: 100%">
                    <textarea name="megjegyzes" {{$tartozas == true ? 'disabled' : ''}} class="megrendelo-textarea">{{$megrendeloHet->megjegyzes}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
        <button onclick="document.rememberScroll()" type="submit" class="btn btn-primary megrendeles-modositas-button megrendeles-modositas-button-id-{{$megrendeloHet->id}}" {{$tartozas == true ? 'disabled' : ''}}>Mentés</button>
    </div>
</form>