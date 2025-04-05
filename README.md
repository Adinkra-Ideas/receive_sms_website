The sample big json object that I made after using individual sample json objects to build the frontends.
This big json object is a connection of all the individual pages sample json, and it helped me understand how to draw the db table relationships.

    $countries = [
        [
            'country_id' => 1,
            'name' => 'United States',
            'alias' => 'USA',
            'active_number_count' => 5,
            'phones' => [
                [
                    'country_id' => 1,
                    'phone_id' => 1,
                    'number' => '14155550135',
                    'service_status' => true,
                    'messages' => [
                        [
                            'phone_id' => 1,
                            'message_id' => 1,
                            'sender' => '14155550135',
                            'sms' => '[Google] Your verification code is: 583921',
                            'send_time' => '2023-12-20 14:30:25 UTC'
                        ],
                        [
                            'phone_id' => 1,
                            'message_id' => 2,
                            'sender' => '12165554321',
                            'sms' => '[Dentist] Reminder: Your appointment tomorrow at 2 PM',
                            'send_time' => '2023-12-20 16:45:00 UTC'
                        ]
                    ]
                ],
                [
                    'country_id' => 1,
                    'phone_id' => 2,
                    'number' => '17035550135',
                    'service_status' => false,
                    'messages' => [
                        [
                            'phone_id' => 2,
                            'message_id' => 1,
                            'sender' => '14155550135',
                            'sms' => '[Google] Your verification code is: 583921',
                            'send_time' => '2023-12-20 14:30:25 UTC'
                        ],
                        [
                            'phone_id' => 2,
                            'message_id' => 2,
                            'sender' => '12165554321',
                            'sms' => '[Dentist] Reminder: Your appointment tomorrow at 2 PM',
                            'send_time' => '2023-12-20 16:45:00 UTC'
                        ]
                    ]
                ]
            ]
        ],
        [
            'country_id' => 2,
            'name' => 'Canada',
            'alias' => 'CA',
            'active_number_count' => 10,
            'phones' => [
                [
                    'country_id' => 2,
                    'phone_id' => 3,
                    'number' => '16195756488',
                    'service_status' => true,
                    'messages' => [
                        [
                            'phone_id' => 3,
                            'message_id' => 1,
                            'sender' => '14155550135',
                            'sms' => '[Google] Your verification code is: 583921',
                            'send_time' => '2023-12-20 14:30:25 UTC'
                        ],
                        [
                            'phone_id' => 3,
                            'message_id' => 2,
                            'sender' => '12165554321',
                            'sms' => '[Dentist] Reminder: Your appointment tomorrow at 2 PM',
                            'send_time' => '2023-12-20 16:45:00 UTC'
                        ]
                    ]
                ],
                [
                    'country_id' => 2,
                    'phone_id' => 4,
                    'number' => '13128489433',
                    'service_status' => true,
                    'messages' => [
                        [
                            'phone_id' => 4,
                            'message_id' => 1,
                            'sender' => '14155550135',
                            'sms' => '[Google] Your verification code is: 583921',
                            'send_time' => '2023-12-20 14:30:25 UTC'
                        ],
                        [
                            'phone_id' => 4,
                            'message_id' => 2,
                            'sender' => '12165554321',
                            'sms' => '[Dentist] Reminder: Your appointment tomorrow at 2 PM',
                            'send_time' => '2023-12-20 16:45:00 UTC'
                        ]
                    ]
                ]
            ]
        ]
    ];
