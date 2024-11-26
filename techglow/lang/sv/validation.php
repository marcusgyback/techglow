<?php

return [
    'accepted'             => ':Attribute måste accepteras.',
    'accepted_if'          => ':Attribute måste accepteras när :other är :value.',
    'active_url'           => ':Attribute är inte en giltig webbadress.',
    'after'                => ':Attribute måste vara ett datum efter :date.',
    'after_or_equal'       => ':Attribute måste vara ett datum senare eller samma dag som :date.',
    'alpha'                => ':Attribute får endast innehålla bokstäver.',
    'alpha_dash'           => ':Attribute får endast innehålla bokstäver, siffror och bindestreck.',
    'alpha_num'            => ':Attribute får endast innehålla bokstäver och siffror.',
    'array'                => ':Attribute måste vara en array.',
    'attached'             => 'Denna :attribute är redan bifogad.',
    'before'               => ':Attribute måste vara ett datum innan :date.',
    'before_or_equal'      => ':Attribute måste vara ett datum före eller samma dag som :date.',
    'between'              => [
        'array'   => ':Attribute måste innehålla mellan :min - :max objekt.',
        'file'    => ':Attribute måste vara mellan :min till :max kilobyte stor.',
        'numeric' => ':Attribute måste vara en siffra mellan :min och :max.',
        'string'  => ':Attribute måste innehålla :min till :max tecken.',
    ],
    'boolean'              => ':Attribute måste vara sant eller falskt.',
    'confirmed'            => ':Attribute bekräftelsen matchar inte.',
    'current_password'     => 'Lösenordet är felaktigt.',
    'date'                 => ':Attribute är inte ett giltigt datum.',
    'date_equals'          => ':Attribute måste vara ett datum lika med :date.',
    'date_format'          => ':Attribute matchar inte formatet :format.',
    'declined'             => ':Attribute måste vara avaktiverat.',
    'declined_if'          => ':Attribute måste vara avaktiverat när :other är :value.',
    'different'            => ':Attribute och :other får inte vara lika.',
    'digits'               => ':Attribute måste vara :digits tecken.',
    'digits_between'       => ':Attribute måste vara mellan :min och :max tecken.',
    'dimensions'           => ':Attribute har felaktiga bilddimensioner.',
    'distinct'             => ':Attribute innehåller fler än en repetition av samma element.',
    'doesnt_end_with'      => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with'    => 'The :attribute may not start with one of the following: :values.',
    'email'                => ':Attribute måste innehålla en korrekt e-postadress.',
    'ends_with'            => ':Attribute måste sluta med en av följande: :values.',
    'enum'                 => ':Attribute är ogiltigt.',
    'exists'               => ':Attribute existerar i databasen och är därför ogiltigt.',
    'file'                 => ':Attribute måste vara en fil.',
    'filled'               => ':Attribute är obligatoriskt.',
    'gt'                   => [
        'array'   => ':Attribute måste innehålla fler än :value objekt.',
        'file'    => ':Attribute måste vara större än :value kilobyte stor.',
        'numeric' => ':Attribute måste vara större än :value.',
        'string'  => ':Attribute måste vara längre än :value tecken.',
    ],
    'gte'                  => [
        'array'   => ':Attribute måste innehålla lika många eller fler än :value objekt.',
        'file'    => ':Attribute måste vara lika med eller större än :value kilobyte stor.',
        'numeric' => ':Attribute måste vara lika med eller större än :value.',
        'string'  => ':Attribute måste vara lika med eller längre än :value tecken.',
    ],
    'image'                => ':Attribute måste vara en bild.',
    'in'                   => ':Attribute är ogiltigt.',
    'in_array'             => ':Attribute finns inte i :other.',
    'integer'              => ':Attribute måste vara en siffra.',
    'ip'                   => ':Attribute måste vara en giltig IP-adress.',
    'ipv4'                 => ':Attribute måste vara en giltig IPv4-adress.',
    'ipv6'                 => ':Attribute måste vara en giltig IPv6-adress.',
    'json'                 => ':Attribute måste vara en giltig JSON-sträng.',
    'lt'                   => [
        'array'   => ':Attribute måste innehålla färre än :value objekt.',
        'file'    => ':Attribute måste vara mindre än :value kilobyte stor.',
        'numeric' => ':Attribute måste vara mindre än :value.',
        'string'  => ':Attribute måste vara kortare än :value tecken.',
    ],
    'lte'                  => [
        'array'   => ':Attribute måste innehålla lika många eller färre än :value objekt.',
        'file'    => ':Attribute måste vara lika med eller mindre än :value kilobyte stor.',
        'numeric' => ':Attribute måste vara lika med eller mindre än :value.',
        'string'  => ':Attribute måste vara lika med eller kortare än :value tecken.',
    ],
    'mac_address'          => ':Attribute måste vara en giltig MAC adress.',
    'max'                  => [
        'array'   => ':Attribute får inte innehålla mer än :max objekt.',
        'file'    => ':Attribute får max vara :max kilobyte stor.',
        'numeric' => ':Attribute får inte vara större än :max.',
        'string'  => ':Attribute får max innehålla :max tecken.',
    ],
    'max_digits'           => 'The :attribute must not have more than :max digits.',
    'mimes'                => ':Attribute måste vara en fil av typen: :values.',
    'mimetypes'            => ':Attribute måste vara en fil av typen: :values.',
    'min'                  => [
        'array'   => ':Attribute måste innehålla minst :min objekt.',
        'file'    => ':Attribute måste vara minst :min kilobyte stor.',
        'numeric' => ':Attribute måste vara större än :min.',
        'string'  => ':Attribute måste innehålla minst :min tecken.',
    ],
    'min_digits'           => 'The :attribute must have at least :min digits.',
    'multiple_of'          => ':Attribute måste vara en multipel av :value',
    'not_in'               => ':Attribute är ogiltigt.',
    'not_regex'            => 'Formatet för :attribute är ogiltigt.',
    'numeric'              => ':Attribute måste vara en siffra.',
    'password'             => [
        'letters'       => 'The :attribute must contain at least one letter.',
        'mixed'         => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers'       => 'The :attribute must contain at least one number.',
        'symbols'       => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present'              => ':Attribute måste finnas med.',
    'prohibited'           => 'Fältet :attribute är förbjudet.',
    'prohibited_if'        => ':Attribute är förbjudet när :other är :value.',
    'prohibited_unless'    => ':Attribute är förbjudet om inte :other är :values.',
    'prohibits'            => ':Attribute fältet förhindrar :other att ha ett värde.',
    'regex'                => ':Attribute har ogiltigt format.',
    'relatable'            => 'Denna :attribute kanske inte är associerad med den här resursen.',
    'required'             => ':Attribute är obligatoriskt.',
    'required_array_keys'  => ':Attribute måste innehålla listnamn för :values.',
    'required_if'          => ':Attribute är obligatoriskt när :other är :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless'      => ':Attribute är obligatoriskt när inte :other finns bland :values.',
    'required_with'        => ':Attribute är obligatoriskt när :values är ifyllt.',
    'required_with_all'    => ':Attribute är obligatoriskt när :values är ifyllt.',
    'required_without'     => ':Attribute är obligatoriskt när :values ej är ifyllt.',
    'required_without_all' => ':Attribute är obligatoriskt när ingen av :values är ifyllt.',
    'same'                 => ':Attribute och :other måste vara lika.',
    'size'                 => [
        'array'   => ':Attribute måste innehålla :size objekt.',
        'file'    => ':Attribute får endast vara :size kilobyte stor.',
        'numeric' => ':Attribute måste vara :size.',
        'string'  => ':Attribute måste innehålla :size tecken.',
    ],
    'starts_with'          => ':Attribute måste börja med en av följande: :values',
    'string'               => ':Attribute måste vara en sträng.',
    'timezone'             => ':Attribute måste vara en giltig tidszon.',
    'unique'               => ':Attribute används redan.',
    'uploaded'             => ':Attribute kunde inte laddas upp.',
    'url'                  => ':Attribute har ett ogiltigt format.',
    'uuid'                 => ':Attribute måste vara ett giltigt UUID.',
    'attributes'           => [
        'address'                  => 'address',
        'age'                      => 'age',
        'amount'                   => 'amount',
        'area'                     => 'area',
        'available'                => 'available',
        'birthday'                 => 'birthday',
        'body'                     => 'body',
        'city'                     => 'city',
        'content'                  => 'content',
        'country'                  => 'country',
        'created_at'               => 'created at',
        'creator'                  => 'creator',
        'current_password'         => 'current password',
        'date'                     => 'date',
        'date_of_birth'            => 'date of birth',
        'day'                      => 'day',
        'deleted_at'               => 'deleted at',
        'description'              => 'description',
        'district'                 => 'district',
        'duration'                 => 'duration',
        'email'                    => 'email',
        'excerpt'                  => 'excerpt',
        'filter'                   => 'filter',
        'first_name'               => 'first name',
        'gender'                   => 'gender',
        'group'                    => 'group',
        'hour'                     => 'hour',
        'image'                    => 'image',
        'last_name'                => 'last name',
        'lesson'                   => 'lesson',
        'line_address_1'           => 'line address 1',
        'line_address_2'           => 'line address 2',
        'message'                  => 'message',
        'middle_name'              => 'middle name',
        'minute'                   => 'minute',
        'mobile'                   => 'mobile',
        'month'                    => 'month',
        'name'                     => 'name',
        'national_code'            => 'national code',
        'number'                   => 'number',
        'password'                 => 'password',
        'password_confirmation'    => 'password confirmation',
        'phone'                    => 'phone',
        'photo'                    => 'photo',
        'postal_code'              => 'postal code',
        'price'                    => 'price',
        'province'                 => 'province',
        'recaptcha_response_field' => 'recaptcha response field',
        'remember'                 => 'remember',
        'restored_at'              => 'restored at',
        'result_text_under_image'  => 'result text under image',
        'role'                     => 'role',
        'second'                   => 'second',
        'sex'                      => 'sex',
        'short_text'               => 'short text',
        'size'                     => 'size',
        'state'                    => 'state',
        'street'                   => 'street',
        'student'                  => 'student',
        'subject'                  => 'subject',
        'teacher'                  => 'teacher',
        'terms'                    => 'terms',
        'test_description'         => 'test description',
        'test_locale'              => 'test locale',
        'test_name'                => 'test name',
        'text'                     => 'text',
        'time'                     => 'time',
        'title'                    => 'title',
        'updated_at'               => 'updated at',
        'username'                 => 'username',
        'year'                     => 'year',
    ],
];
