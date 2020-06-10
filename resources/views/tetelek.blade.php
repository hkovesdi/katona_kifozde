@extends('app')

@section('content')

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
                @foreach($tetelTablazat as $napIdx => $tetelTablazatSor)
                    <tr>
                        <th scope="row">{{Helper::getNapFromDayOfWeek($napIdx)}}</th>
                        <form method="POST" action="{{route('tetelArModositas')}}" id="tetel-ar-modosito-form">
                            @csrf
                            @foreach($tetelTablazatSor as $tetelNev => $tetelTablazatOszlop)
                                <td>
                                    <input type="hidden" name="tetelek[{{$napIdx}}][{{$tetelNev}}][id]" value={{$tetelTablazatOszlop['id']}}>
                                    <input name="tetelek[{{$napIdx}}][{{$tetelNev}}][ar]" class="tetel-table-input" type="number" value={{$tetelTablazatOszlop['ar']}}>Ft&nbsp;
                                </td>
                            @endforeach
                        <form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-check" style="padding-left: 0px">
            <input name="jovohettol" class="tetel-ar-modosito-form" type="checkbox" id="jovohettol-check">
            <label class="form-check-label" for="jovohettol-check">Jövőhéttől</label>
        </div>
        <div style="text-align: right">
            <button class="btn btn-success my-1" type="submit">Mentés</button>
        </div>
        </div>
      </div>
    </div>
</div>
  

@stop