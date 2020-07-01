@extends('layouts.nyomtatvanyokHTML') 
@section('content')

<div style="text-align: center;">
    <div><h3>{{$datum['datum']}}</h3></div>
    <div class="mt-1"><h3>{{$datum['het']}}. hét</h3></div>
    <div class="mt-2"><h3>{{Helper::getNapFromDayOfWeek($datum['nap'])}}</h3></div>
</div>



<table class="szakacs-table table-sm table-striped table-bordered mt-1" style="margin: auto;">

    <thead class="szakacs-thead">
        <tr>
            <th>
                Menü
            </th>
            <th>
                Adag
            </th>
        </tr>
    </thead>

    <tbody>
        
            @foreach ($tetelek as $tetel)
                <tr>

                    <td scope="col">
                        {{$tetel['nev']}}
                    </td>

                    <td scope="col">
                        {{$tetel['darab']}} db
                    </td>

                </tr>
            @endforeach
        
    </tbody>

</table>

<div  class="mt-5" style="text-align:center">
    @foreach($megjegyzesek as $megjegyzes)
        @if($megjegyzes != null)        
        <div class="megjegyzes">
            <h4><i class="fas fa-times no-print" style="color: red; cursor:pointer"></i>&nbsp{{$megjegyzes}}</h4>
        </div>
        @endif
    @endforeach
</div>

<script>
 $(document).on('click', '.fa-times', function() {
     $(this).parents('.megjegyzes').hide();
 });
</script>

@stop