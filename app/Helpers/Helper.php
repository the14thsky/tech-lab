<?php

// Custom Helpers

use Illuminate\Validation\ValidationException;

if (!function_exists('validate')){
    function validate($data,$rules,$messages = [],$error_msg = null)
    {
        $validator = validator($data,$rules,$messages);
        if($validator->fails()){
            $error_msg = ($error_msg != null)?__($error_msg):__('auth.validation_failed');
            abort(response()->json(['data' => $validator->errors()->toArray(),'status' => 'error','code' => 422,'message' => $error_msg],422));
            return false;
        }
		try{
			return $validator->validated();
		}catch(ValidationException $e){
        	return $e->getMessage();
		}
	}
}
