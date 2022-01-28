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

    'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'image' => 'Das :attribute muss ein Bild sein.',
    'max' => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file' => 'Das :attribute darf nicht größer sein als :max Kilobyte.',
        'string' => 'Das :attribute darf nicht größer als :max Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes' => 'Das :attribute muss eine Datei des Typs sein: :values.',
    'min' => [
        'numeric' => 'Das :attribute muss mindestens :min . sein.',
        'file' => 'Das :attribute muss mindestens :min Kilobyte groß sein.',
        'string' => 'Das :attribute muss mindestens :min Zeichen enthalten.',
        'array' => 'Das :attribute muss mindestens :min Elemente enthalten.',
    ],
    'password' => 'Das Passwort ist inkorrekt.',
    'required' => 'Das :attribute feld ist erforderlich.',
    'same' => ':attribute und :other müssen übereinstimmen.',
    'unique' => 'Das :attribute wurde bereits vergeben.',
    'string' => 'Das :attribute muss ein String sein.',
    'numeric' => 'Das :attribute muss eine Zahl sein.',
    'confirmed' => 'Die :attribute bestätigung stimmt nicht überein.',
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
            'rule-name' => 'benutzerdefinierte Nachricht',
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
        'title' => 'Titel',
        'name' => 'Name',
        'auto_reply' => 'automatische Antwort',
        'email' => 'Email',
        'port' => 'Hafen',
        'password' => 'Passwort',
        'smtp_port' => 'SMTP-Port',
        'subject' => 'Gegenstand',
        'ticket_urgency_id' => 'Ticket-Dringlichkeits-ID',
        'ticket_status_id' => 'Ticketstatus-ID',
        'reply' => 'Antwort',
        'attachments.*' => 'Anhänge',
        'note' => 'Hinweis',
        'language' => 'Sprache',
        'code' => 'Code',
        'c_password' => 'Kennwort bestätigen',
        'extension' => 'Verlängerung',
        'message' => 'Botschaft',
        'smtp_host' => 'SMTP-Host',
        'smtp_password' => 'SMTP-Passwort',
        'color' => 'Farbe',
        'imap_host' => 'IMAP-Host',
        'imap_port' => 'IMAP-Port',
        'imap_password' => 'IMAP-Passwort',
        'ticket_user_id' => 'Benutzer',
        'body' => 'Karosserie',
        'status' => 'Status',
        'language_id' => 'Sprache',
        'category_id' => 'Kategorie',
        'question' => 'Frage',
        'answer' => 'Antworten',
        'internal_note' => 'Hinweis',
        'description' => 'Bezeichnung',
        'icon' => 'Symbol',
        'text' => 'Oben',
        'textarea' => 'Oben',
        'tag_color' => 'Tag-Farbe',
        'text_color' => 'Textfarbe',
    ],
    'value' => [

    ],
    'other' => [
        'password' => 'Passwort',
        'title' => 'Titel',

    ],
    'values' => [

    ],
    'max' => [
        'title' => 'Titel', 
    ],

];
