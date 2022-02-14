<?php

namespace App\Http\Controllers;

use App\Helpers\GeolocationHelper;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function getSuppliers( Request $request, $id )
    {
        $client = new Client(['base_uri' => 'https://61f16556072f86001749f1b7.mockapi.io/api/v1/']);

        $customers = $client->request( 'GET', 'customers' );
        $suppliers = $client->request( 'GET', 'suppliers' );

        $customer = collect( json_decode( $customers->getBody() ) )->where( 'id', $id )->first();

        if( $customer ) {
            $customer_lat = $customer->address->lat;
            $customer_lon = $customer->address->long;

            $selectedSuppliers = collect( json_decode( $suppliers->getBody() ) )->filter( function( $supplier ) use( $customer_lat, $customer_lon ) {
                $supplier_lat = $supplier->address->lat;
                $supplier_lon = $supplier->address->long;
                $range        = $supplier->range;
                $distance     = GeolocationHelper::getDistance( $customer_lat, $customer_lon, $supplier_lat, $supplier_lon );

                return $distance <= $range;
            });
        }

        return $selectedSuppliers;
    }
}
