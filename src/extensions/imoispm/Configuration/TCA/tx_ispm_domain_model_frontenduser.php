<?php
return [
    'ctrl' => [
        'title' => 'Frontend User',
        'label' => 'username',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'useColumnsForDefaultValues' => 'pid',
        'allowed' => 10,
        'searchFields' => 'username,name,first_name,middle_name,last_name,email',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/frontend_user.svg',
    ],
    'types' => [
        '0' => ['showitem' => 'username, password, name, first_name, middle_name, last_name, address, email, --div--;Visibility, hidden, starttime, endtime'],
    ],
    'columns' => [
        'username' => [
            'exclude' => true,
            'label' => 'Benutzername',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'password' => [
            'exclude' => true,
            'label' => 'Passwort',
            'config' => [
                'type' => 'password',
                'required' => true,
            ],
        ],
        'first_name' => [
            'exclude' => true,
            'label' => 'Vorname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'last_name' => [
            'exclude' => true,
            'label' => 'Nachname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'Email',
            'config' => [
                'type' => 'email',
                'required' => false,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'Hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'Starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'Endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
    ],
];
