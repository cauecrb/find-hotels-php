<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindController extends Controller
{


public function find(Request $request){

    //get the JSON
    $json_file = file_get_contents("https://buzzvel-interviews.s3.eu-west-1.amazonaws.com/hotels.json");
    $json_str = json_decode($json_file, true);
    $itens = $json_str['message'];

    /**
     * function that calculates the distance and converts it to KM
     * @param $lat
     * @param $long
     * @param $lat2
     * @param $long2
     * @return float
     */
    function calcDist( $lat, $long, $lat2, $long2){
        $lat_rad = floatval($lat) * pi() / 180;
        $long_rad = floatval($long) *pi() / 180;
        $lat_rad2 = $lat2 * pi() / 180;
        $long_rad2 = $long2 *pi() / 180;

        $distance = (ACOS(COS($lat_rad) * COS($long_rad) * COS($lat_rad2) * COS($long_rad2) + COS($lat_rad) * SIN($long_rad) * COS($lat_rad2) * SIN($long_rad2) + SIN($lat_rad) * SIN($lat_rad2)) * 6371) * 1.15;
        $distance = round($distance,2);
        return $distance;
    }

    /**
     * function that returns hotels filtered by distance or price
     * @param $param
     * @param $array
     * @return mixed
     */
    function orderBy($param, $array){
        $x=0;
        if ($param === "1"){
            foreach ( $array as $price ){
                $arrayPrice[$x] =  $price[3].$price[0];
                $x++;
            }
            $x=0;
            sort($arrayPrice,SORT_NUMERIC);
                foreach ( $array as $hotel ){
                    foreach ( $array as $hotel ) {
                        if (is_string($arrayPrice[$x])){
                            if (str_contains($arrayPrice[$x], $hotel[0])) {
                                $arrayPrice[$x] = $hotel;
                            }
                        }
                    }
                    $x++;
                }
            return $arrayPrice;
        }
        else{
            foreach ( $array as $km ){
                $arrayKm[$x] =  $km['KM'];
                $x++;
            }
            $x=0;
            sort($arrayKm);
            foreach ( $array as $km ){
                foreach ( $array as $hotel ){
                    if($arrayKm[$x] == $hotel['KM'] ) {
                        $arrayKm[$x] = $hotel;
                    }
                }
                $x++;
            }
            return $arrayKm;
        }
    }

    /**
     * foreach that finds the hotels that are within the maximum distance
     *
     */
    $i = 0;
    foreach ( $itens as $e )
    {
        $e['KM'] = calcDist($e[1], $e[2], $request->lat, $request->long);
        if($e['KM'] <= $request->maxDist){
            $arrayHotels[$i] = $e;
            $i++;
        }

    }

    /**
     * call function to order hotels
     *
     */
    $hotelsOrdered = orderBy($request->orderby, $arrayHotels, $request->maxDist);

    return view('find', ['hotelsOrdered' => $hotelsOrdered]);
    }
}
