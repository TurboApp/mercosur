<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createTrasbordoRequest extends FormRequest
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
        $rules= [
            'datos_generales.cliente_id'      => 'required|max:11',
            'datos_generales.agente_id'       => 'required|max:11',
            'datos_generales.fecha_recepcion' => 'required',
            'datos_generales.hora_recepcion'  => 'required',
            'datos_generales.destino'         => 'required|max:191',
            'datos_generales.destino_pais'    => 'required|max:60',
            
            'transporte.descarga.id_linea_transporte'  => 'required|max:11',
            'transporte.descarga.nombre_operador'      => 'required|max:120',
            'transporte.descarga.talon_embarque'       => 'required|max:191',
            'transporte.descarga.marca_vehiculo'       => 'required|max:191',
            'transporte.descarga.placas_tractor'       => 'required|max:191',
            'transporte.descarga.placas_caja'          => 'required|max:191',
            'transporte.descarga.tipo_unidad'          => 'required|max:191',
            'transporte.descarga.medida_unidad'        => 'required|max:30',
            'transporte.descarga.ejes'                 => 'required|max:25',
            'transporte.descarga.cantidad'             => 'required|max:2',   

            'transporte.carga.id_linea_transporte'  => 'required|max:11',
            'transporte.carga.nombre_operador'      => 'required|max:120',
            'transporte.carga.talon_embarque'       => 'required|max:191',
            'transporte.carga.marca_vehiculo'       => 'required|max:191',
            'transporte.carga.placas_tractor'       => 'required|max:191',
            'transporte.carga.placas_caja'          => 'required|max:191',
            'transporte.carga.tipo_unidad'          => 'required|max:191',
            'transporte.carga.medida_unidad'        => 'required|max:30',
            'transporte.carga.ejes'                 => 'required|max:25',
            'transporte.carga.cantidad'             => 'required|max:2',   
        ];
       
        foreach($this->request->get('documento') as $key => $val)
        {
          $rules['documento.'.$key.'.tipo_documento'] = 'required|max:45';
          $rules['documento.'.$key.'.documento'] = 'required|max:60';
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
        
        $messages['transporte.descarga.id_linea_transporte.required'] = 'Por favor seleccione una linea de transporte valida';
        $messages['transporte.descarga.nombre_operador.required'] = 'El nombre del opreador es requerido';
        $messages['transporte.descarga.talon_embarque.required'] = 'El numero de talon de obligarotio';
        $messages['transporte.descarga.marca_vehiculo.required'] = 'La marca de vehiculo es un dato obligatorio';
        $messages['transporte.descarga.placas_tractor.required'] = 'Las placas del tractor es un campo obligatorio';
        $messages['transporte.descarga.placas_caja.required'] = 'Las placas de la caja es un campo obligatorio';
        $messages['transporte.descarga.tipo_unidad.required'] = 'El tipo de unidad es requerido';
        $messages['transporte.descarga.medida_unidad.required'] = 'Las medidas de la unidad es un campo requerido';
        $messages['transporte.descarga.ejes.required'] = 'El numero de ejes es un campo requerido';
        $messages['transporte.descarga.cantidad.required'] = 'La cantidad es un campo requerido';
        
        $messages['transporte.carga.id_linea_transporte.required'] = 'Por favor seleccione una linea de transporte valida';
        $messages['transporte.carga.nombre_operador.required'] = 'El nombre del opreador es requerido';
        $messages['transporte.carga.talon_embarque.required'] = 'El numero de talon de obligarotio';
        $messages['transporte.carga.marca_vehiculo.required'] = 'La marca de vehiculo es un dato obligatorio';
        $messages['transporte.carga.placas_tractor.required'] = 'Las placas del tractor es un campo obligatorio';
        $messages['transporte.carga.placas_caja.required'] = 'Las placas de la caja es un campo obligatorio';
        $messages['transporte.carga.tipo_unidad.required'] = 'El tipo de unidad es requerido';
        $messages['transporte.carga.medida_unidad.required'] = 'Las medidas de la unidad es un campo requerido';
        $messages['transporte.carga.ejes.required'] = 'El numero de ejes es un campo requerido';
        $messages['transporte.carga.cantidad.required'] = 'La cantidad es un campo requerido';
    
      foreach($this->request->get('documento') as $key => $val)
      {
        $messages['documento.'.$key.'.tipo_documento.required'] = 'El Tipo de documento es obligatorio. Vuelva a intentarlo';
        $messages['documento.'.$key.'.documento.required'] = 'El Nombre ó Numero de documento es requerido. Vuelva a intentarlo';
      }
      return $messages;
    }
}
