<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestServicio extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        
        $rules['datos_generales.cliente_id'     ] = 'required|max:11';
        $rules['datos_generales.agente_id'      ] = 'required|max:11';
        $rules['datos_generales.fecha_recepcion'] = 'required';
        $rules['datos_generales.hora_recepcion' ] = 'required';
        $rules['datos_generales.destino'        ] = 'required|max:191';
        $rules['datos_generales.destino_pais'   ] = 'required|max:60';
        
        if($this->request->get('tipo') === 'Carga')
        {
            foreach($this->request->get('transporte') as $key => $val)
            {
                $rules['transporte.'.$key.'.Destino.linea_transporte_id']  = 'required|max:11';
                $rules['transporte.'.$key.'.Destino.nombre_operador' ]     = 'required|max:120';
                $rules['transporte.'.$key.'.Destino.talon_embarque'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.marca_vehiculo'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.placas_tractor'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.placas_caja'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.tipo_unidad'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.medida_unidad'   ]     = 'required|max:30';
                $rules['transporte.'.$key.'.Destino.ejes'            ]     = 'required|max:25';
                $rules['transporte.'.$key.'.Destino.cantidad'        ]     = 'required|max:2';
            }

        }
        elseif($this->request->get('tipo') === 'Descarga')
        {
            foreach($this->request->get('transporte') as $key => $val)
            {
                $rules['transporte.'.$key.'.Origen.linea_transporte_id']  = 'required|max:11';
                $rules['transporte.'.$key.'.Origen.nombre_operador' ]     = 'required|max:120';
                $rules['transporte.'.$key.'.Origen.talon_embarque'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.marca_vehiculo'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.placas_tractor'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.placas_caja'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.tipo_unidad'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.medida_unidad'   ]     = 'required|max:30';
                $rules['transporte.'.$key.'.Origen.ejes'            ]     = 'required|max:25';
                $rules['transporte.'.$key.'.Origen.cantidad'        ]     = 'required|max:2';
            }
        }elseif($this->request->get('tipo') === 'Trasbordo'){
            foreach($this->request->get('transporte') as $key => $val)
            {
                $rules['transporte.'.$key.'.Destino.linea_transporte_id']  = 'required|max:11';
                $rules['transporte.'.$key.'.Destino.nombre_operador' ]     = 'required|max:120';
                $rules['transporte.'.$key.'.Destino.talon_embarque'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.marca_vehiculo'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.placas_tractor'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.placas_caja'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.tipo_unidad'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Destino.medida_unidad'   ]     = 'required|max:30';
                $rules['transporte.'.$key.'.Destino.ejes'            ]     = 'required|max:25';
                $rules['transporte.'.$key.'.Destino.cantidad'        ]     = 'required|max:2';

                $rules['transporte.'.$key.'.Origen.linea_transporte_id']  = 'required|max:11';
                $rules['transporte.'.$key.'.Origen.nombre_operador' ]     = 'required|max:120';
                $rules['transporte.'.$key.'.Origen.talon_embarque'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.marca_vehiculo'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.placas_tractor'  ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.placas_caja'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.tipo_unidad'     ]     = 'required|max:191';
                $rules['transporte.'.$key.'.Origen.medida_unidad'   ]     = 'required|max:30';
                $rules['transporte.'.$key.'.Origen.ejes'            ]     = 'required|max:25';
                $rules['transporte.'.$key.'.Origen.cantidad'        ]     = 'required|max:2';
            }

        }
        
        
        foreach($this->request->get('documento') as $key => $val)
        {
            $rules['documento.'.$key.'.tipo_documento'] = 'required|max:45';
            $rules['documento.'.$key.'.num_documento'] = 'required|max:60';
        }

        return $rules;
    }

    public function messages()
    {
        $messages['datos_generales.cliente_id.required'] = 'Por favor seleccione un cliente valido';
        $messages['datos_generales.agente_id.required'] = 'Por favor Seleccione el un agente';
        $messages['datos_generales.fecha_recepcion.required'] = 'La fecha de recepción es obligatoria';
        $messages['datos_generales.hora_recepcion.required'] = 'La hora de recepción es obligatoria';
        $messages['datos_generales.destino.required'] = 'El campo destinatario es requerido';
        $messages['datos_generales.destino_pais.required'] = 'El país destino es obligatorio';
            
        foreach($this->request->get('transporte') as $key => $val)
        {
            $rules['transporte.'.$key.'.Destino.linea_transporte_id.required']  = 'Por favor seleccione una linea de transporte valida';
            $rules['transporte.'.$key.'.Destino.nombre_operador.required' ]     = 'El nombre del opreador es requerido';
            $rules['transporte.'.$key.'.Destino.talon_embarque.required'  ]     = 'El numero de talon de obligarotio';
            $rules['transporte.'.$key.'.Destino.marca_vehiculo.required'  ]     = 'La marca de vehiculo es un dato obligatorio';
            $rules['transporte.'.$key.'.Destino.placas_tractor.required'  ]     = 'Las placas del tractor es un campo obligatorio';
            $rules['transporte.'.$key.'.Destino.placas_caja.required'     ]     = 'Las placas de la caja es un campo obligatorio';
            $rules['transporte.'.$key.'.Destino.tipo_unidad.required'     ]     = 'El tipo de unidad es requerido';
            $rules['transporte.'.$key.'.Destino.medida_unidad.required'   ]     = 'Las medidas de la unidad es un campo requerido';
            $rules['transporte.'.$key.'.Destino.ejes.required'            ]     = 'El numero de ejes es un campo requerido';
            $rules['transporte.'.$key.'.Destino.cantidad.required'        ]     = 'La cantidad es un campo requerido';

            $rules['transporte.'.$key.'.Origen.linea_transporte_id.required']  = 'Por favor seleccione una linea de transporte valida';
            $rules['transporte.'.$key.'.Origen.nombre_operador.required' ]     = 'El nombre del opreador es requerido';
            $rules['transporte.'.$key.'.Origen.talon_embarque.required'  ]     = 'El numero de talon de obligarotio';
            $rules['transporte.'.$key.'.Origen.marca_vehiculo.required'  ]     = 'La marca de vehiculo es un dato obligatorio';
            $rules['transporte.'.$key.'.Origen.placas_tractor.required'  ]     = 'Las placas del tractor es un campo obligatorio';
            $rules['transporte.'.$key.'.Origen.placas_caja.required'     ]     = 'Las placas de la caja es un campo obligatorio';
            $rules['transporte.'.$key.'.Origen.tipo_unidad.required'     ]     = 'El tipo de unidad es requerido';
            $rules['transporte.'.$key.'.Origen.medida_unidad.required'   ]     = 'Las medidas de la unidad es un campo requerido';
            $rules['transporte.'.$key.'.Origen.ejes.required'            ]     = 'El numero de ejes es un campo requerido';
            $rules['transporte.'.$key.'.Origen.cantidad.required'        ]     = 'La cantidad es un campo requerido';
        }

        foreach($this->request->get('documento') as $key => $val)
        {
            $messages['documento.'.$key.'.tipo_documento.required'] = 'El tipo de documento es requerido';
            $messages['documento.'.$key.'.num_documento.required'] = 'El Numero de documento es requerido. Vuelva a intentarlo';
        }

        return $messages;
    }
}
