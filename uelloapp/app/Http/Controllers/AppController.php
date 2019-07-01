<?php

namespace Uello\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Client as HTTP;

/**
 * 
 * Load client model
 */
use Uello\Models\Client;

class AppController extends Controller
{
    private $url = "https://maps.googleapis.com/maps/api/geocode/json?address={{address}}&key={{key}}";
    
    public function index ()
    {
        return view( 'home' );
    }

    public function upload ( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'csv_file'  =>  'required' ], [
            'required'  =>  'Selecione um aquivo.',
        ]);

        if ( $validator->fails() )
        {
            foreach ($validator->errors()->all() as $message) {
                return response()->json([
                    'status'    =>  'error',
                    'message'   =>  $message
                ], 400 );
            }
        }

        /**
         * 
         * Pega o endereço temporário do csv
         */
        $path = $request->file('csv_file')->getRealPath();

        /**
         * 
         * Cria um collection laravel
         */
        $collection = collect( file($path) );

        /**
         * 
         * Limpa os cabeçalhos
         */
        $collection->forget(0);

        /**
         * 
         * Mapeando a collect e criando o array com os parametro
         * que queremos inserir no banco ded dados
         */
        $data = $collection->map(function ($item, $key ) {
            $item = explode( ';', $item );
            
            # HTTP GUZZLE
            $http = new HTTP();
            $response = $http->get( str_ireplace( ['{{address}}', '{{key}}'], [$item[4], env('GOOGLE_GEOENCODING_KEY')], $this->url ) );

            if( $response->getStatusCode() == 200 )
            {
                $result = json_decode( $response->getBody()->getContents(), true );
                $lat = $result['results'][0]['geometry']['location']['lat'];
                $lng = $result['results'][0]['geometry']['location']['lng'];
            }

            $addrs = $item[4];

            $address = explode( ',', $item[4] );

            $complements = explode( '-', $address[1] );
           
            $number = null;
            $others = null;

            $count = 0;
            foreach( explode( ' ', $complements[0] ) as $x ) {
                if( $x == "" ) {
                    unset( $x );
                }
                else {
                    if( $count == 0 ) {
                        $number = $x;
                    }
                    else {
                        $others .= $x . ' ';
                    }
                    $count++;
                }
            }
            
            return [
                'name'      =>  $item[0],
                'email'     =>  $item[1],
                'birthday'  =>  $item[2],
                'doc'       =>  $item[3],
                'address'   =>  [
                    'name'      =>  trim( $address[0] ),
                    'number'    =>  trim( $number ),
                    'complement'=>  ( $others != null ) ? trim( $others ) : null,
                    'neighborhood'  =>  trim( $complements[1] ),
                    'city'          =>  trim( $complements[2] ),
                    'zipcode'       =>  trim( $item[5] ),
                    'latitude'      =>  $lat ?? null,
                    'longitude'     =>  $lng ?? null,
                ]
            ];        
        });

        DB::beginTransaction();
        try
        {
            foreach( $data->all() as $dataToInset )
            {
                $cliente = Client::create([
                    'name'      =>  $dataToInset['name'],
                    'email'     =>  $dataToInset['email'],
                    'birthday'  =>  $dataToInset['birthday'],
                    'document_number'   =>  $dataToInset['doc'],
                ]);

                $cliente->address()->create([
                    'client_id'    =>  $cliente->id,
                    'address'       =>  $dataToInset['address']['name'],
                    'number'        =>  $dataToInset['address']['number'],
                    'complement'    =>  $dataToInset['address']['complement'],
                    'neighborhood'  =>  $dataToInset['address']['neighborhood'],
                    'city'          =>  $dataToInset['address']['city'],
                    'zip_code'      =>  $dataToInset['address']['zipcode'],
                    'latitude'      =>  $dataToInset['address']['latitude'],
                    'longitude'     =>  $dataToInset['address']['longitude'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status'    =>  'error',
                'message'   =>  'Dados inseridos com sucesso',
            ], 201 );
        }
        catch( \Exception $e )
        {
            DB::rollBack();
            dd( $e );
            return response()->json([
                'status'    =>  'error',
                'message'   =>  'Erro ao inserir os dados na banco',
            ], 400 );
        }
    }

    public function list ()
    {
        $clients = Client::all();

        return view( 'list', compact( 'clients' ));
    }
}
