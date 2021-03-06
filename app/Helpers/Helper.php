<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Illuminate\Support\Carbon;

class Helper
{   

    /**
     * Visszaad egy tömböt a hétköznapok neveivel
     */
    public static function hetkoznapok()
    {
        return array('Hétfő','Kedd','Szerda','Csütörtök','Péntek');
    }


    /** 
     * Visszaadja a paraméterben kapott nap sorszámának magyar nevét
     * @param int $dayOfWeek : a hét napjának sorszáma
     * @return string
    */
    public static function getNapFromDayOfWeek(int $dayOfWeek) 
    {
        switch($dayOfWeek){
            case 1:
                return 'Hétfő';
            case 2:
                return 'Kedd';
            case 3:
                return 'Szerda';
            case 4:
                return 'Csütörtök';
            case 5:
                return 'Péntek';
            case 6:
                return 'Szombat';
            case 7:
                return 'Vasárnap';
        }
    }


    /**
     * Elkészíti az üres megrendelés táblázatot
     * @return array Az üres táblázat [nap][tételNév] formában
     */
    public static function constructEmptyMegrendelesTablazat() 
    {
        $tetelNevek = array_fill_keys(\App\TetelNev::all()->pluck('nev')->toArray(), array_fill_keys(array('egesz','fel','ar'),0));
        $hetkoznapok = array_fill_keys(array(1,2,3,4,5), null);

        foreach($hetkoznapok as &$hetkoznap) {
            $hetkoznap = $tetelNevek;
        }
        
        return $hetkoznapok;
    }

    /**
     * Elkészíti az üres tétel táblázatot
     * @return array Az üres táblázat [nap][tételNév] formában
     */
    public static function constructEmptyTetelTablazat() 
    {
        $tetelNevek = array_fill_keys(\App\TetelNev::all()->pluck('nev')->toArray(), array_fill_keys(array('id','ar'),0));
        $hetkoznapok = array_fill_keys(array(1,2,3,4,5), null);

        foreach($hetkoznapok as &$hetkoznap) {
            $hetkoznap = $tetelNevek;
        }
        
        return $hetkoznapok;
    }

    public static function parseEvHet($evHet) 
    {   
        $parsedEvHet = array();
        if($evHet === null) {
            $parsedEvHet[0] = Carbon::now()->year;
            $parsedEvHet[1] = Carbon::now()->weekOfYear;
        }
        else {
            $parsedEvHet = explode("-", $evHet);
        }

        return $parsedEvHet;
    }


    /**
     * Az fél és egész adagok darabszámából elkészíti a megrendelés táblázatban megjelítendő stringet.
     * @param int $egesz : Az egész adagok száma
     * @param int $fel : A féladagok száma
     * @return string
     */
    public static function adagokToString(int $egesz, int $fel) 
    {
        if($egesz > 0 && $fel > 0) {
            return $egesz.'x'.$fel.'F';
        }
        else if($egesz > 0) {
            return strval($egesz);
        }
        else if($fel > 0) {
            return $fel.'F';
        }
        else {
            return "";
        }
    }
}


?>