<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createDescargasRequest extends FormRequest
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
            
            'transporte.id_linea_transporte'  => 'required|max:11',
            'transporte.nombre_operador'      => 'required|max:120',
            'transporte.talon_embarque'       => 'required|max:191',
            'transporte.marca_vehiculo'       => 'required|max:191',
            'transporte.placas_tractor'       => 'required|max:191',
            'transporte.placas_caja'          => 'required|max:191',
            'transporte.tipo_unidad'          => 'required|max:191',
            'transporte.medida_unidad'        => 'required|max:30',
            'transporte.ejes'                 => 'required|max:25',
            'transporte.cantidad'             => 'required|max:2',   
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
        $messages['transporte.id_linea_transporte.required'] = 'Por favor seleccione una linea de transporte valida';
        $messages['transporte.nombre_operador.required'] = 'El nombre del opreador es requerido';
        $messages['transporte.talon_embarque.required'] = 'El numero de talon de obligarotio';
        $messages['transporte.marca_vehiculo.required'] = 'La marca de vehiculo es un dato obligatorio';
        $messages['transporte.placas_tractor.required'] = 'Las placas del tractor es un campo obligatorio';
        $messages['transporte.placas_caja.required'] = 'Las placas de la caja es un campo obligatorio';
        $messages['transporte.tipo_unidad.required'] = 'El tipo de unidad es requerido';
        $messages['transporte.medida_unidad.required'] = 'Las medidas de la unidad es un campo requerido';
        $messages['transporte.ejes.required'] = 'El numero de ejes es un campo requerido';
        $messages['transporte.cantidad.required'] = 'La cantidad es un campo requerido';
    
      foreach($this->request->get('documento') as $key => $val)
      {
        $messages['documento.'.$key.'.tipo_documento.required'] = 'El Tipo de documento es obligatorio. Vuelva a intentarlo';
        $messages['documento.'.$key.'.documento.required'] = 'El Nombre ó Numero de documento es requerido. Vuelva a intentarlo';
      }
      return $messages;
    }

}
