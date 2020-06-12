@extends('app')

@section('content')

<div id="week-counter">
    <a class="baljobbgombA" href="/tetelek/{{$het-1 === 0 ? $ev-1 : $ev}}-{{$het-1 === 0 ? 53 : $het-1}}">
        <button type="button" class="baljobbgomb arrows"><i class="fas fa-arrow-left"></i></button>
    </a>
    <span id="het-text">{{$ev}} - {{$het}}. hét</span>
    @if($ev < \Carbon\Carbon::now()->year || $het <= \Carbon\Carbon::now()->weekOfYear)
        <a class="baljobbgombA" href="/tetelek/{{$het+1 > 53 ? $ev+1 : $ev}}-{{$het+1 > 53 ? 1 : $het+1}}">
            <button type="button" class="baljobbgomb baljobbgombR arrows"><i class="fas fa-arrow-right"></i></button>
        </a>
    @endif
</div>

@if($letezik)
<div class="flex-left mt-5 ml-4 mr-4">
    <div>
    <div class="card">
        <div class="card-body">
          <h1 class="card-title">Tételek</h1>
          <div class="table-responsive-xl">
            <table class="modified-table table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Nap</th>
                    @foreach($tetelNevek as $tetelNev)
                        <th scope="col">{{$tetelNev}}</th>
                    @endforeach
                </tr>
                </thead>
                    <tbody>
                    <form method="POST" action="{{route('tetelArModositas')}}" id="tetel-ar-modosito-form">
                        @csrf
                        <input type="hidden" name="ev" value={{$ev}}>
                        <input type="hidden" name="het" value={{$het}}>
                        @foreach($tetelTablazat as $napIdx => $tetelTablazatSor)
                            <tr>
                                <th scope="row">{{Helper::getNapFromDayOfWeek($napIdx)}}</th>
                                    @foreach($tetelTablazatSor as $tetelNev => $tetelTablazatOszlop)
                                        <td>
                                            <input type="hidden" name="tetelek[{{$napIdx}}][{{$tetelNev}}][id]" value={{$tetelTablazatOszlop['id']}}>
                                            <input name="tetelek[{{$napIdx}}][{{$tetelNev}}][ar]" class="tetel-table-input" type="number" value={{$tetelTablazatOszlop['ar']}} {{$ev < \Carbon\Carbon::now()->year || $het < \Carbon\Carbon::now()->weekOfYear ? 'disabled' : ''}}>Ft&nbsp;
                                        </td>
                                    @endforeach
                            </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
        </div>
        <div style="text-align: right">
            <button class="btn btn-success my-1" form="tetel-ar-modosito-form" type="submit" {{$tetelTablazatOszlop['ar']}} {{$ev < \Carbon\Carbon::now()->year || $het < \Carbon\Carbon::now()->weekOfYear ? 'disabled' : ''}}>Mentés</button>
        </div>
        </div>
      </div>
    </div>
</div>
@else
    <h1 class="heti-ertesito mt-3">Nincsenek tételek ezen a héten</h1>
@endif
  

@stop