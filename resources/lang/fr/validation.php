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

    'mimes' => 'L :attribute doit être un fichier de type: :values.',
    'min' => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file' => 'Le :attribute doit être au moins :min kilo-octets.',
        'string' => 'Le :attribute doit être au moins :min personnages.',
        'array' => 'Le :attribute doit avoir au moins :min éléments.',
    ],
    'password' => 'Le mot de passe est incorrect.',
    'required' => 'Le champ :attribute est obligatoire.',
    'same' => 'Les :attribute et :other doivent correspondre.',
    'unique' => 'Le :attribute a déjà été pris.',
    'email' => 'Le :attribute doit être une adresse e-mail valide.',
    'image' => 'Le :attribute doit être une image.',
    'string' => 'Le :attribute doit être une chaîne.',
    'numeric' => 'Le :attribute doit être un nombre.',
    'confirmed' => 'La confirmation :attribute ne correspond pas.',

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
        'title' => 'Titre',
        'name' => 'Nom',
        'auto_reply' => 'réponse automatique',
        'email' => 'e-mail',
        'port' => 'Port',
        'password' => 'le mot de passe',
        'smtp_port' => 'port SMTP',
        'subject' => 'matière',
        'ticket_urgency_id' => 'ID durgence du ticket',
        'ticket_status_id' => 'identifiant du statut du ticket',
        'reply' => 'réponse',
        'attachments.*' => 'pièces jointes',
        'note' => 'Remarque',
        'language' => 'Langue',
        'code' => 'code',
        'c_password' => 'Confirmez le mot de passe',
        'extension' => 'extension',
        'message' => 'un message',
        'color' => 'Couleur',
        'smtp_host' => 'hôte SMTP',
        'smtp_password' => 'mot de passe SMPT',
        'imap_host' => 'Hôte IMAP',
        'imap_port' => 'Port IMAP',
        'imap_password' => 'IMAP Mot de passe IMAP',
        'host' => 'hôte',
        'ticket_user_id' => 'utilisateur',
        'body' => 'corps',
        'status' => 'statut',
        'language_id' => 'Langue',
        'category_id' => 'Catégorie',
        'question' => 'question',
        'answer' => 'réponse',
        'internal_note' => 'Remarque',
        'description' => 'la description',
        'icon' => 'icône',
        'text' => 'dessus',
        'textarea' => 'dessus',
        'tag_color' => "couleur de l'étiquette",
        'text_color' => 'couleur du texte',
    ],
    'value' => [

    ],
    'other' => [
        'password' => 'le mot de passe',
        

    ],
    'max' => [
        'title' => 'Titre',
    ],

];