<?php

namespace App\Helpers;

class GeolocationHelper {
    public static function getDistance( Float $lat1, Float $lon1, Float $lat2, Float $lon2 )
    {
        $lat1 = deg2rad( $lat1 );
        $lat2 = deg2rad( $lat2 );
        $lon1 = deg2rad( $lon1 );
        $lon2 = deg2rad( $lon2 );

        $dist = ( 6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin( $lat2 ) ) );

        return $dist;
    }
}