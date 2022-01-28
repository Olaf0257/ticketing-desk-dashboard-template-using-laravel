<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */


    'email' => 'El :attribute  debe ser una dirección de correo electrónico válida.',
    'image' => 'El :attribute debe ser una imagen.',
    'max' => [
        'numeric' => 'El :attribute no puede ser mayor que :max.',
        'file' => 'El :attribute no puede ser mayor que :max kilobytes.',
        'string' => 'El :attribute no puede ser mayor que :max caracteres.',
        'array' => 'El :attribute no puede tener más de :max artículos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file' => 'El :attribute debe ser al menos :min kilobytes.',
        'string' => 'El :attribute debe ser al menos :min caracteres.',
        'array' => 'El :attribute debe tener al menos :min artículos.',
    ],
    'password' => 'La contraseña es incorrecta.',
    'required' => 'El campo de :attribute es obligatorio',
    'same' => 'El :attribute y :other debe coincidir con.',
    'unique' => 'El :attribute ya se ha tomado.',
    'string' => 'El :attribute debe ser una cuerda.',
    'numeric' => 'El :attribute debe ser un número.',
    'confirmed' => 'El la confirmación del :attribute no coincide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'title' => 'título',
        'name' => 'nombre',
        'auto_reply' => 'respuesta automática',
        'email' => 'Email',
        'port' => 'Puerto',
        'password' => 'contraseña',
        'smtp_port' => 'puerto SMTP',
        'subject' => 'Sujeto',
        'ticket_urgency_id' => 'ID de urgencia del ticket',
        'ticket_status_id' => 'ID de estado del ticket',
        'reply' => 'respuesta',
        'attachments.*' => 'archivos adjuntos',
        'note' => 'Nota',
        'language' => 'idioma',
        'code' => 'código',
        'c_password' => 'confirmar Contraseña',
        'extension' => 'extensión',
        'message' => 'mensaje',
        'color' => 'color',
        'smtp_host' => 'host SMPT',
        'smtp_password' => 'contraseña SMPT',
        'imap_host' => 'IMAP Anfitrión',
        'imap_port' => 'IMAP Puerto',
        'imap_password' => 'IMAP Contraseña',
        'host' => 'Anfitrión',
        'ticket_user_id' => 'usuario',
        'body' => 'cuerpo',
        'status' => 'estado',
        'language_id' => 'idioma',
        'category_id' => 'categoría',
        'question' => 'pregunta',
        'answer' => 'respuesta',
        'internal_note' => 'Nota',
        'description' => 'descripción',
        'icon' => 'icono',
        'text' => 'encima',
        'textarea' => 'encima',
        'tag_color' => 'color de la etiqueta',
        'text_color' => 'color de texto',
        
    ],
    'value' => [

    ],
    'other' => [
        'password' => 'contraseña',
        

    ],
    'max' => [
        'title' => 'título', 
    ],


];