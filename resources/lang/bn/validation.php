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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'এই ভ্যালুটি অবশ্যই অ্যারে হতে হবে।',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'এই ভ্যালুটি অবশ্যই :min থেকে :max মধ্যে হতে হবে।',
        'file' => 'এই ভ্যালুটি অবশ্যই :min থেকে :max কিলোবাইটের মধ্যে হতে হবে।',
        'string' => 'এই ভ্যালুটি অবশ্যই :min থেকে :max ক্যারেক্টারের মধ্যে হতে হবে।',
        'array' => 'এই ভ্যালুটি অবশ্যই :min থেকে :max আইটেমের মধ্যে হতে হবে।',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
    'date' => 'এটি একটি বৈধ তারিখ নয়।',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'এই ভ্যালুটি এই :format ফরম্যাটের সাথে মেলেনি',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'এই ইমেইলটি অবশ্যই বৈধ ইমেল অ্যাড্রেস হতে হবে।',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'নির্বাচিত ভ্যালুটি অবৈধ।',
    'file' => 'এই ভ্যালুটি অবশ্যই একটি ফাইল হতে হবে।',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'এই ভ্যালুটি অবশ্যই একটি ছবি হতে হবে।',
    'in' => 'নির্বাচিত ভ্যালুটি অবৈধ।',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'এই ভ্যালুটি অবশ্যই পূর্ণসংখ্যা হতে হবে।',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'এই ভ্যালুটি :max এর বেশি হতে পারবে না।',
        'file' => 'এই ভ্যালুটি :max কিলোবাইটের বেশি হতে পারবে না।',
        'string' => 'এই ভ্যালুটি :max ক্যারেক্টারের বেশি হতে পারবে না।',
        'array' => 'এই ভ্যালুটি আইটেমের এর বেশি হতে পারবে না।',
    ],
    'mimes' => 'এই ভ্যালুটির ফাইল টাইপ :values হতে হবে।',
    'mimetypes' => 'এই ভ্যালুটির ফাইল টাইপ :values হতে হবে।',
    'min' => [
        'numeric' => 'এই ভ্যালুটি কমপক্ষে :min হতে হবে।',
        'file' => 'এই ভ্যালুটি কমপক্ষে :min কিলোবাইটের হতে হবে।',
        'string' => 'এই ভ্যালুটি কমপক্ষে :min ক্যারেক্টারের হতে হবে।',
        'array' => 'এই ভ্যালুটি কমপক্ষে :min আইটেমের হতে হবে।',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'এই ভ্যালুটি অবশ্যই একটি সংখ্যা হবে।',
    'password' => 'এই পাসওয়ার্ডটি ভূল।',
    'present' => 'The :attribute field must be present.',
    'regex' => 'এই ফরম্যাটটি বৈধ না।',
    'required' => 'এই ঘরটি অবশ্যই পূরণ করতে হবে।',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'নতুন পাসওয়ার্ডটি নিশ্চিতকরণ পাসওয়ার্ডের সাথে অবশ্যই মিলতে হবে।',
    'size' => [
        'numeric' => 'এই ভ্যালুটি অবশ্যই :size হতে হবে।',
        'file' => 'এই ভ্যালুটি অবশ্যই :size কিলোবাইটের হতে হবে।',
        'string' => 'এই ভ্যালুটি অবশ্যই :size ক্যারেক্টারের হতে হবে।',
        'array' => 'এই ভ্যালুটি অবশ্যই :size আইটেমের হতে হবে।',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'এই ভ্যালুটি অবশ্যই স্ট্রিং হতে হবে।',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'এই ভ্যালুটি ইতিমধ্যেই নেওয়া হয়েছে।',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

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

    'attributes' => [],

];
