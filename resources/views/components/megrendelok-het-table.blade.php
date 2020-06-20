<table role="table" class="main-table">
    <thead role="rowgroup" class="main-thead">
        <tr role="row">
            <th role="columnheader" class="fejlec-center row-rend">Törlés</th>
            <th role="columnheader" class="fejlec-center row-rend">Rendelések</th>
            <th role="columnheader" class="fejlec-center row-nev">Név</th>
            <th role="columnheader" class="fejlec-center row-cim">Cim</th>
            <th role="columnheader" class="fejlec-center row-tel">Tel</th>
            <th role="columnheader" class="fejlec-center row-fizm">Fizetési mód</th>
            <th role="columnheader" class="fejlec-center row-fizm">Kedvezmény</th>
            <th role="columnheader" class="fejlec-center row-ossz">Összeg</th>
            <th role="columnheader" class="fejlec-center row-fiz">Fizetett</th>
        </tr>
    </thead>
    <tbody role="rowgroup" class="main-tbody sortable-table">

        @foreach($megrendeloHetek as $megrendeloHet)
            <form method="POST" id="megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-form" action="{{route('megrendeloHetTorles', ['user' => $user, 'megrendeloHet' => $megrendeloHet])}}">
                @csrf
            </form>
            <form id="kedvezmeny-form-{{$megrendeloHet->id}}" method="post" action="{{route('kedvezmenyValtoztatas', $megrendeloHet)}}">
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
                              <button type="submit" form="megrendelo-{{$megrendeloHet->megrendelo['id']}}-torles-form" class="btn btn-success" {{count($megrendeloHet['megrendelesek']) > 0 ? 'disabled' : ''}}>Törlés</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <td role="cell" class="centercell">
                        <button class="btn-rend megrendeles-modal-button" 
                            data-toggle="modal" 
                            data-target="#megrendelo-{{$tartozas == true ? 'tartozas-' : 'megrendeles-'}}{{$megrendeloHet->megrendelo['id']}}-modal"
                            type="button">Menüsor
                        </button>
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
                        <span><input {{$megrendeloHet->fizetve_at === null ? '' : 'disabled'}} type="number" form="kedvezmeny-form-{{$megrendeloHet->id}}" name="kedvezmeny" class="kedvezmeny-input megrendelo-het-id-{{$megrendeloHet->id}}" value={{$megrendeloHet['kedvezmeny']}} style="width:33px">%</span>
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
<div class="modal" tabindex="-1" role="dialog" id="megrendelo-{{$tartozas == true ? 'tartozas-' : 'megrendeles-'}}{{$megrendeloHet->megrendelo['id']}}-modal" data-megrendelo-het-id="{{$megrendeloHet->id}}">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$megrendeloHet->megrendelo['nev']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="ajax-content">
                    <div class="flex-center">
                        <div class="progress-circular">
                            <div class="progress-circular-wrapper">
                            <div class="progress-circular-inner">
                                <div class="progress-circular-left">
                                <div class="progress-circular-spinner"></div>
                                </div>
                                <div class="progress-circular-gap"></div>
                                <div class="progress-circular-right">
                                <div class="progress-circular-spinner"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="button" class="btn btn-primary" disabled >Mentés</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach