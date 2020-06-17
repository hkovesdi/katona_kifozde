<table role="table" class="main-table">
    <thead role="rowgroup" class="main-thead">
        <tr role="row">
            <th role="columnheader" class="fejlec-center row-rend">Törlés</th>
            <th role="columnheader" class="fejlec-center row-rend">Rendelések</th>
            <th role="columnheader" class="fejlec-center row-nev">Név</th>
            <th role="columnheader" class="fejlec-center row-cim">Cim</th>
            <th role="columnheader" class="fejlec-center row-tel">Tel</th>
            <th role="columnheader" class="fejlec-center row-fizm">Fizetési mód</th>
            <th role="columnheader" class="fejlec-center row-ossz">Összeg</th>
            <th role="columnheader" class="fejlec-center row-fiz">Fizetett</th>
        </tr>
    </thead>
    <tbody role="rowgroup" class="main-tbody sortable-table">

        @foreach($megrendeloHetek as $megrendeloHet)
            <form method="POST" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-form" action="{{route('megrendeloHetTorles', ['user' => $user, 'megrendeloHet' => $megrendeloHet])}}">
                @csrf
            </form>
            <form class="ajax fizetesi-status-modosito-form form-id-{{$megrendeloHet->id}}" method="post" action="{{route('fizetesiStatuszModositas', $megrendeloHet)}}">
                @csrf
                <tr role="row" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}">
                    <td role="cell" class="centercell"><button type="button" class="text-button" data-toggle="modal" data-target="#megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-modal" style="text-align: center;"><i class="fas fa-user-minus" style="color: red;"></button></i></td>
                    <div class="modal" tabindex="-1" role="dialog" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-modal">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Megrendelő törlése a hétről</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body mt-3">
                              <p style="font-size: 16px">Biztos benne, hogy törölni szeretné a megrendelőt erről a hétről?</p>
                              <p style="font-size: 12px"><i class="fas fa-info-circle"  style="font-size: 15px; color: #6699ff"></i> A megrendelőt csak akkor lehet törölni a hétről, ha nincsen hozzá tartozó rendelés a héten.</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Mégsem</button>
                              <button type="submit" form="megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-form" class="btn btn-success" {{$megrendeloHet->osszeg != 0 ? 'disabled' : ''}}>Törlés</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <td role="cell" class="centercell">
                        <button class="btn-rend" data-toggle="modal" data-target="#megrendelo-{{$tartozas == true ? 'tartozas-' : 'megrendeles-'}}{{$megrendeloHet->megrendelo['id']}}-modal" type="button">Menüsor</button>
                    </td>
                    <td role="cell" name="nev"><span>{{$megrendeloHet->megrendelo['nev']}}</span></td>
                    <td role="cell" name="szallitasi-cim"><span>{{$megrendeloHet->megrendelo['szallitasi_cim']}}</span></td>
                    <td role="cell" name="telefonszam"><span>{{$megrendeloHet->megrendelo['telefonszam']}}</span></td>
                    <td role="cell" class="centercell" name="fizetesi-mod">
                        <span>
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
                        </span>
                    </td>
                    <td role="cell" class="centercell">
                        <span>
                            <a tabindex="0" class="osszeg-osszesito" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="Összeg összesítő" data-content="{{$megrendeloHet->osszeg_osszesito}}">{{$megrendeloHet->osszeg}} Ft</a>
                        </span>
                    </td>
                    <td role="cell" class="centercell">
                        <span>
                            <input type="hidden" name="torles" value="{{ $megrendeloHet['fizetve_at'] !== null ? 1 : 0 }}">
                            <input type="hidden" name="megrendelo-het-id" value="{{ $megrendeloHet['id'] }}">
                            @if ($megrendeloHet['fizetve_at'] !== null)
                            <button type="button" class="fizetve-button-kifizetve fizetve-button fizetve-modal fizetve-button-id-{{$megrendeloHet->id}}" >Fizetve</button>

                            @else
                                <button type="button" class="fizetve-button fizetve-modal fizetve-button-id-{{$megrendeloHet->id}}">Fizetve</button>
                            @endif
                        </span>
                    </td>
                </tr>
            </form>
        @endforeach
    </tbody>
</table>

@foreach($megrendeloHetek as $megrendeloHet)
    <div class="modal" tabindex="-1" role="dialog" id="megrendelo-{{$tartozas == true ? 'tartozas-' : 'megrendeles-'}}{{$megrendeloHet->megrendelo['id']}}-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$megrendeloHet->megrendelo['nev']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('megrendelesModositas')}}" method="post" class="megrendeles-modositas-form megrendeles-modositas-id-{{$megrendeloHet->id}}">
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
                        <button onclick="document.rememberScroll()" type="button" class="btn btn-primary megrendeles-modositas-button megrendeles-modositas-button-id-{{$megrendeloHet->id}}" {{$tartozas == true ? 'disabled' : ''}}>Mentés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach