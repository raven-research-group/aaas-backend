<?php

return [

    'user' => [
        'type' => 'Admin,Standard'
    ],

    'passwordRegex' => [
        'message' => 'The password must contain at least 8 characters, including at least one uppercase letter, one number, and one special character (e.g., @, $, !, %, *, ? or &).'
    ],

    'passwordMin' => [
        'length' => 8,
        'message' => 'The password must be at least 8 characters long.'
    ],

];