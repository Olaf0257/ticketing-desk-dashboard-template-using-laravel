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

    'mimes' => ':attribute 必须是以下类型的文件： :values.',
    'min' => [
        'numeric' => ':attribute 必须至少 :min.',
        'file' => ':attribute 必须至少 :min 千字节.',
        'string' => ':attribute 必须至少t :min 人物.',
        'array' => ':attribute 必须至少具有 :min 项目.',
    ],
    'password' => '密码错误',
    'required' => ':attribute 字段是必填字段。',
    'same' => ':attribute 和 :other 必须匹配。',
    'unique' => ':attribute 已经被使用。',
    'email' => ':attribute 必须是有效的电子邮件地址。',


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
        'title' => '标题',
        'name' => '姓名',
        'auto_reply' => '自动回复',
        'email' => '电子邮件',
        'port' => '港口',
        'password' => '密码',
        'smtp_port' => 'SMTP端口',
        'subject' => '学科',
        'ticket_urgency_id' => '子弹头紧迫性',
        'ticket_status_id' => '票证状态ID',
        'reply' => '回复',
        'attachments.*' => '附件',
        'note' => '笔记',
        'language' => '语言',
        'code' => '代码',
        'c_password' => '确认密码',
        'extension' => '扩大',
        'message' => '信息',
        'color' => '颜色',
        'smtp_host' => 'SMTP主机',
        'smtp_password' => 'SMTP密码',
        'imap_host' => 'IMAP主持人',
        'imap_port' => 'IMAP港口',
        'imap_password' => 'IMAP密码',
        'host' => '主机',
        'ticket_user_id' => '用户',
    ],
    'value' => [

    ],
    'other' => [
        'password' => '密码',

    ],

];