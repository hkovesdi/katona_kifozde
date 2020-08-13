@extends('layouts.nyomtatvanyokHTML') 
@section('content')

<div style="text-align: center;" class="mt-5">
    <div><h2>{{$datum['datum']}}</h2></div>
    <div class="mt-1"><h2>{{$datum['het']}}. hét</h2></div>
    <div class="mt-2"><h2>{{Helper::getNapFromDayOfWeek($datum['nap'])}}</h2></div>
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
        <div class="megrendelo-megjegyzes">
            <span><i class="fas fa-times no-print" style="color: red; cursor:pointer"></i>&nbsp{{$megjegyzes}}</span>
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