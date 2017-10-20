<?php

use Illuminate\Database\Seeder;

class DescargasDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for($i = 0; $i < 400; $i++) {

            $date = Carbon\Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp())->format('Y-m-j');
            $numero_servicio = App\OrdenServicio::getNumServicio();
            
            //Store Datos generales - orden_servicios
            $datos_generales=[
                'tipo'            => $faker->randomElement(['Descarga','Carga','Trasbordo']),//'Descarga',
                'agente_id'       => $faker->numberBetween(1,10),
                'cliente_id'      => $faker->numberBetween(1,10),
                'numero_servicio' => $numero_servicio,
                'fecha_recepcion' => $date,//$faker->date('d/m/Y', 'now'),
                'hora_recepcion'  => $faker->time('H:i', 'now'),
                'destino'         => $faker->address,
                'destino_pais'    => $faker->country,
                'status'          => 'Para asignar', //$faker->randomElement(['PARA ASIGNAR','EN PROCESO','EN PAUSA','FINALIZADO','CANCELADO']),     
                'observaciones'   => $faker->text(100)
            ];

            $ordenServicio = App\OrdenServicio::create($datos_generales);

            
            $transporte_carga = [
                'id_orden_servicio'    =>   $ordenServicio->id,
                'id_linea_transporte'  =>   $faker->numberBetween(1,88),
                'nombre_operador'      =>   $faker->name('male'),
                'tipo_unidad'          =>   $faker->randomElement(["RABON",
                                                                    "TORTON",
                                                                    "CAJA SECA",
                                                                    "FULL / DOBLE SEMIREMOLQUE",
                                                                    "CAJA REFRIGERADA",
                                                                    "PLATAFORMA",
                                                                    "AUTOTANQUE / PIPA",
                                                                    "AUTOTANQUE PARA ASFALTO / GRANEL",
                                                                    "JAULA A GRANEL / GRANELERA",
                                                                    "JAULA GANADERA",
                                                                    "JAULA ENLONADA / CORTINA",
                                                                    "LOW BOY / CAMA BAJA",
                                                                    "TOLVA",]), 
                'medida_unidad'        =>   $faker->randomElement(['26 PIES','35 PIES','40 PIES','45 PIES','48 PIES','53 PIES']),
                'ejes'                 =>   $faker->numberBetween(4,10), 
                'cantidad'             =>   $faker->numberBetween(1,3), 
                'talon_embarque'       =>   $faker->numberBetween(1000,9000),
                'marca_vehiculo'       =>   $faker->sentence(4), 
                'placas_tractor'       =>   $faker->word() . $faker->numberBetween( 1000, 9000 ), 
                'placas_caja'          =>   $faker->word() . $faker->numberBetween( 1000, 9000 ), 
                'type'                 =>   'Carga'
            ];

            $transporte_descarga = [
                'id_orden_servicio'    =>   $ordenServicio->id,
                'id_linea_transporte'  =>   $faker->numberBetween(1,88),
                'nombre_operador'      =>   $faker->name('male'),
                'tipo_unidad'          =>   $faker->randomElement(["RABON",
                                                                    "TORTON",
                                                                    "CAJA SECA",
                                                                    "FULL / DOBLE SEMIREMOLQUE",
                                                                    "CAJA REFRIGERADA",
                                                                    "PLATAFORMA",
                                                                    "AUTOTANQUE / PIPA",
                                                                    "AUTOTANQUE PARA ASFALTO / GRANEL",
                                                                    "JAULA A GRANEL / GRANELERA",
                                                                    "JAULA GANADERA",
                                                                    "JAULA ENLONADA / CORTINA",
                                                                    "LOW BOY / CAMA BAJA",
                                                                    "TOLVA",]), 
                'medida_unidad'        =>   $faker->randomElement(['26 PIES','35 PIES','40 PIES','45 PIES','48 PIES','53 PIES']),
                'ejes'                 =>   $faker->numberBetween(4,10), 
                'cantidad'             =>   $faker->numberBetween(1,3), 
                'talon_embarque'       =>   $faker->numberBetween(1000,9000),
                'marca_vehiculo'       =>   $faker->sentence(4), 
                'placas_tractor'       =>   $faker->word() . $faker->numberBetween( 1000, 9000 ), 
                'placas_caja'          =>   $faker->word() . $faker->numberBetween( 1000, 9000 ), 
                'type'                 =>   'Descarga'
            ];

            //Store Transportes - orden_servicios_transportes
            if($ordenServicio->tipo === 'Trasbordo')
            {
                App\OrdenServicioTransporte::create($transporte_descarga);
                App\OrdenServicioTransporte::create($transporte_carga);
                for ( $x = 0 ; $x < $faker->randomDigit ; $x++ ){
                    $documento = [
                        'descarga_id' => $ordenServicio->id,
                        'carga_id' => $ordenServicio->id,
                        'tipo_documento' => $faker->randomElement(['FACTURA','REMISIÓN','PREGUIA']),
                        'documento'      => $faker->word() . $faker->numberBetween(1000,9000),
                        'descripcion'    => $faker->text(199), 
                    ];
                    App\Documento::create( $documento );
                }
            }
            elseif($ordenServicio->tipo === 'Descarga'){
                App\OrdenServicioTransporte::create($transporte_descarga);
                //Store Documentos - documentos
                for ( $x = 0 ; $x < $faker->randomDigit ; $x++ ){
                    $documento = [
                        'descarga_id' => $ordenServicio->id,
                        'tipo_documento' => $faker->randomElement(['FACTURA','REMISIÓN','PREGUIA']),
                        'documento'      => $faker->word() . $faker->numberBetween(1000,9000),
                        'descripcion'    => $faker->text(199), 
                        'status' => 1
                    ];
                    App\Documento::create( $documento );
                }
                //Store Archivos - archivos
                for ( $y=0 ; $y< $faker->randomDigit ; $y++ ){
                    App\Archivo::create([
                        'descarga_id' => $ordenServicio->id,
                        'nombre'            => $faker->word(),
                        'url'               => $faker->imageUrl( 640, 480),
                        'extension'         => $faker->fileExtension,
                        'size'              => $faker->numberBetween(1000,9000),
                        'minetype'          => $faker->mimeType,
                    ]);
                }
            }
            else
            {
                App\OrdenServicioTransporte::create($transporte_carga);
                $documento = [
                    'descarga_id' => $ordenServicio->id,
                    'tipo_documento' => $faker->randomElement(['FACTURA','REMISIÓN','PREGUIA']),
                    'documento'      => $faker->word() . $faker->numberBetween(1000,9000),
                    'descripcion'    => $faker->text(199), 
                ];
                $archivo = [
                    'descarga_id' => $ordenServicio->id,
                    'nombre'            => $faker->word(),
                    'url'               => $faker->imageUrl( 640, 480),
                    'extension'         => $faker->fileExtension,
                    'size'              => $faker->numberBetween(1000,9000),
                    'minetype'          => $faker->mimeType,
                ];
                //Update Documentos
                $ordenServicio->updateDocumentos($documento);
                //Update Archivos
                $ordenServicio->updateArchivos($archivo);
            }
        
            //Asignar turno
            
            $coordinacion = App\Coordinacion::whereDate('fecha_servicio', $ordenServicio->fecha_recepcion)->orderBy('turno','desc')->first();
            
            if($coordinacion){
                $turno = $coordinacion->turno + 1; 
            }else{
                $turno = 1;
            }
            
            //Store Coordinacion - coordinacions
            App\Coordinacion::create([
                'id_orden_servicio' => $ordenServicio->id,
                'fecha_servicio'    => $ordenServicio->fecha_recepcion,
                'turno'             => $turno
            ]);
            
        }

    }
}


