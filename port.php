<?php
    // 1. Include required model files
    require_once dirname(__FILE__, 1) . '/models/Country.php';
    require_once dirname(__FILE__, 1) . '/models/Phone.php';
    require_once dirname(__FILE__, 1) . '/models/Message.php';
    require_once dirname(__FILE__, 1) . '/models/UnsentSMS.php';

    // 2. Include your database connection file
    require_once dirname(__FILE__, 1) . '/config/Database.php';

    // 3. Obtain a database connection
    $database = new Database();
    $conn = $database->getConnection();

    // Instantiate required models
    $country = new Country($conn);
    $phone = new Phone($conn);
    $message = new Message($conn);
    $unsent_sms = new UnsentSMS($conn);


    // FOR ADDING A NEW COUNTRY
    if ( isset($_GET['country']) && isset($_GET['alias'])
        && $_GET['country'] !== ''
        && $_GET['alias'] !== ''
    ) {
        // Request for adding a new Country to our countries table. We do just that
        // Now use the Country model's create() method
        $country->name = $_GET['country'];
        $country->alias = $_GET['alias'];
        if ( $country->create() ) {
            echo "country {$country->name} with alias {$country->alias} created successfully!";
        } else {
            echo "error!";
        }
        die;
    }


    // FOR ADDING A NEW PHONE NUMBER
    else if ( isset($_GET['alias']) && isset($_GET['number']) && isset($_GET['service_status'])
        && $_GET['alias'] !== ''
        && $_GET['number'] !== ''
        && $_GET['service_status'] !== ''
    ) {
        // Request for adding a new phone number to our phones table. We do just that
        // Now use the Phone model's create() method
        $phone->country_alias = $_GET['alias'];
        $phone->number = $_GET['number'];
        $phone->service_status = $_GET['service_status'] == 'active' ? true : false;

        if ( $phone->create() ) {
            echo "country {$phone->country_alias} with phone {$phone->number} created successfully!";

            // THIS CALL SHOULD BE RELOCATED INTO THE MODEL
            // Here we will adjust countries.active_number_count accordingly
            if ( $phone->service_status ) {
                $country->alias = $phone->country_alias;
                if ( $country->updateActiveNumberCount(1) ) {
                    echo " | countries table also incremented accordingly";
                }
                die;
            }

        } else {
            echo "error!";
        }
        die;
    }


    // FOR SETTING A PHONE NUMBER ACTIVE OR INACTIVE
    else if ( isset($_GET['alias']) && isset($_GET['number']) && isset($_GET['new_service_status'])
        && $_GET['alias'] !== ''
        && $_GET['number'] !== ''
        && $_GET['new_service_status'] !== ''
    ) {
        // Request for updating the service_status of a phone number in our phones table. We do just that
        // Now use the Phone model's updateServiceStatus() method
        $phone->country_alias = $_GET['alias'];
        $phone->number = $_GET['number'];
        $phone->service_status = $_GET['new_service_status'] == 'active' ? true : false;
        if ( $phone->updateServiceStatus() ) {
            echo "updated successfully!";

            // THIS CALL SHOULD BE RELOCATED INTO THE MODEL
            // Here we will adjust countries.active_number_count accordingly
            $country->alias = $phone->country_alias;
            if ( $country->updateActiveNumberCount( ($phone->service_status ? 1 : -1) ) ) {
                echo " | countries table also incremented accordingly";
            }

        } else {
            echo "not updated!";
        }
        die;

    }

    // FOR ADDING A NEW SMS
    else if ( isset($_GET['sender']) && isset($_GET['sms']) && isset($_GET['receiver'])
        && $_GET['sender'] !== ''
        && $_GET['sms'] !== ''
        && $_GET['receiver'] !== ''
    ) {
        $message->sender = $_GET['sender'];
        $message->sms = $_GET['sms'];

        if ( $message->create($_GET['receiver']) ) {
            echo "created successfully!";
        } else {
            echo "error!";
        }
        die;
    }


    // FOR ADDING BULK UNSENT SMS TO THE UnsentSMS TABLE
    else if ( isset($_GET['addunsent'])) {
        // Get JSON input
        $json_data = file_get_contents('php://input');

        // Initialize response array
        $response = [
            'success' => false,
            'message' => '',
            'inserted_count' => 0,
            'errors' => []
        ];

        // Validate JSON
        if (empty($json_data)) {
            $response['message'] = 'No data received';
            echo json_encode($response);
            die;
        }

        $data = json_decode($json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $response['message'] = 'Invalid JSON format';
            echo json_encode($response);
            die;
        }

        // Validate SMS data structure
        if (!is_array($data) || count($data) === 0) {
            $response['message'] = 'Invalid SMS data format';
            echo json_encode($response);
            die;
        }

        $insert_count = 0;

        foreach ($data as $sender => $sms) {
            if ($unsent_sms->create($sender, $sms) !== false) {
                $insert_count++;
            }
        }

        // Prepare final response
        $response['success'] = $insert_count > 0;
        $response['inserted_count'] = $insert_count;
        $response['message'] = $insert_count > 0
            ? "Successfully stored $insert_count SMS messages"
            : "No messages were stored";

        echo json_encode([
            'status' => 'success',
            'data' => $response
        ]);
        die;
    }








    $database->closeConnection();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS JSON Input Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            height: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        #response {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
        }
    </style>
</head>
<body>

    <h1>SMS Submission Form</h1>
    <form id="smsForm">
        <div class="form-group">
            <label for="jsonInput">Enter SMS JSON:</label>
            <textarea id="jsonInput" name="jsonInput" placeholder='{"13564587698":"hello this is an sms","AMAZON":"this is another sms","15551234567": "urgent system update"}'></textarea>
        </div>
        <button type="submit">Submit SMS</button>
    </form>
    <div id="response"></div>
    <script>
        document.getElementById('smsForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const responseDiv = document.getElementById('response');
            responseDiv.innerHTML = '';

            try {
                const jsonInput = document.getElementById('jsonInput').value;

                const response = await fetch('/port?addunsent=', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: jsonInput
                });

                // Handle different response types
                const contentType = response.headers.get('content-type') || '';
                let result;

                if (contentType.includes('application/json')) {
                    result = await response.json();
                } else {
                    const text = await response.text();
                    result = {
                        success: response.ok,
                        message: text,
                        inserted_count: 0,
                        errors: []
                    };
                }

                // Handle display
                if (result.success) {
                    responseDiv.className = 'success';
                    responseDiv.innerHTML = `
                        <h3>Success!</h3>
                        <p>${result.message}</p>
                        ${result.inserted_count !== undefined ? `
                        <p>Inserted count: ${result.inserted_count}</p>
                        ` : ''}
                        ${result.errors?.length ? `
                        <h4>Errors:</h4>
                        <ul>
                            ${result.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                        ` : ''}
                    `;
                } else {
                    responseDiv.className = 'error';
                    responseDiv.innerHTML = `
                        <h3>Error (HTTP ${response.status})</h3>
                        <p>${result.message}</p>
                        ${result.errors?.length ? `
                        <h4>Errors:</h4>
                        <ul>
                            ${result.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                        ` : ''}
                    `;
                }
            } catch (error) {
                responseDiv.className = 'error';
                responseDiv.innerHTML = `
                    <h3>Request Failed!</h3>
                    <p>${error.message}</p>
                    <p>Check console for details</p>
                `;
                console.error('Submission error:', error);
            }
        });
    </script>



    <!-- New Add Phone Number Form -->
    <h2>Add new phone number</h2>
    <form id="addNumberForm">
        <div class="form-group">
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phoneNumber" name="number" required>
        </div>
        <div class="form-group">
            <label for="alias">Alias:</label>
            <input type="text" id="alias" name="alias" value="USA" required>
        </div>
        <div class="form-group">
            <label for="serviceStatus">Service Status:</label>
            <input type="text" id="serviceStatus" name="service_status" value="active" required>
        </div>
        <button type="submit">Add Phone Number</button>
    </form>
    <div id="numberResponse"></div>

    <script>
        // Existing SMS form script remains unchanged

        // Add new form submission handler
        document.getElementById('addNumberForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const responseDiv = document.getElementById('numberResponse');
                responseDiv.innerHTML = '';

                try {
                    const params = new URLSearchParams({
                        number: document.getElementById('phoneNumber').value,
                        alias: document.getElementById('alias').value,
                        service_status: document.getElementById('serviceStatus').value
                    });

                    const response = await fetch(`/port?${params}`, {
                                    method: 'GET'
                            });

                    // Handle non-JSON responses
                    const contentType = response.headers.get('content-type') || '';
                    let result;

                    if (contentType.includes('application/json')) {
                        result = await response.json();
                    } else {
                        const text = await response.text();
                        result = {
                            success: response.ok,
                            message: text,
                            errors: []
                        };
                    }

                    // Handle display
                    if (result.success) {
                        responseDiv.className = 'success';
                        responseDiv.innerHTML = `<h3>Success!</h3><p>${result.message}</p>`;
                    } else {
                        responseDiv.className = 'error';
                        responseDiv.innerHTML = `
                            <h3>Error (HTTP ${response.status})</h3>
                            <p>${result.message}</p>
                            ${result.errors?.length ? `
                            <h4>Errors:</h4>
                            <ul>
                                ${result.errors.map(error => `<li>${error}</li>`).join('')}
                            </ul>
                            ` : ''}
                        `;
                    }
                } catch (error) {
                    responseDiv.className = 'error';
                    responseDiv.innerHTML = `
                        <h3>Request Failed!</h3>
                        <p>${error.message}</p>
                        <p>Check console for details</p>
                    `;
                    console.error('Request failed:', error);
                }
            });

    </script>



    <!-- Add New Country Form -->
    <h2>ADD NEW COUNTRY</h2>
    <form id="addCountryForm">
        <div class="form-group">
            <label for="countryKey">Country Key:</label>
            <input type="text" id="countryKey" name="country" required>
        </div>
        <div class="form-group">
            <label for="countryAlias">Alias:</label>
            <input type="text" id="countryAlias" name="alias" required>
        </div>
        <button type="submit">Add Country</button>
    </form>
    <div id="countryResponse"></div>
    <script>
            // Add Country Form Handler
            document.getElementById('addCountryForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const responseDiv = document.getElementById('countryResponse');
                responseDiv.innerHTML = '';

                try {
                    const params = new URLSearchParams({
                        country: document.getElementById('countryKey').value,
                        alias: document.getElementById('countryAlias').value
                    });

                    const response = await fetch(`/port?${params}`, {
                        method: 'GET'
                    });

                    const contentType = response.headers.get('content-type') || '';
                    let result;

                    if (contentType.includes('application/json')) {
                        result = await response.json();
                    } else {
                        const text = await response.text();
                        result = {
                            success: response.ok,
                            message: text,
                            errors: []
                        };
                    }

                    if (result.success) {
                        responseDiv.className = 'success';
                        responseDiv.innerHTML = `<h3>Success!</h3><p>${result.message}</p>`;
                    } else {
                        responseDiv.className = 'error';
                        responseDiv.innerHTML = `
                            <h3>Error (HTTP ${response.status})</h3>
                            <p>${result.message}</p>
                            ${result.errors?.length ? `
                            <h4>Errors:</h4>
                            <ul>
                                ${result.errors.map(error => `<li>${error}</li>`).join('')}
                            </ul>
                            ` : ''}
                        `;
                    }
                } catch (error) {
                    responseDiv.className = 'error';
                    responseDiv.innerHTML = `
                        <h3>Request Failed!</h3>
                        <p>${error.message}</p>
                        <p>Check console for details</p>
                    `;
                    console.error('Country request failed:', error);
                }
            });
    </script>




    <!-- New Set Phone Status Form -->
        <h2>SET PHONE NUMBER STATUS</h2>
        <form id="setPhoneStatusForm">
            <div class="form-group">
                <label for="statusAlias">Alias:</label>
                <input type="text" id="statusAlias" name="alias" required>
            </div>
            <div class="form-group">
                <label for="statusNumber">Phone Number:</label>
                <input type="text" id="statusNumber" name="number" required>
            </div>
            <div class="form-group">
                <label for="newServiceStatus">New Status:</label>
                <input type="text" id="newServiceStatus" name="new_service_status" required>
            </div>
            <button type="submit">Update Status</button>
        </form>
        <div id="statusResponse"></div>
    <script>
        // Set Phone Status Form Handler
        document.getElementById('setPhoneStatusForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const responseDiv = document.getElementById('statusResponse');
            responseDiv.innerHTML = '';

            try {
                const params = new URLSearchParams({
                    alias: document.getElementById('statusAlias').value,
                    number: document.getElementById('statusNumber').value,
                    new_service_status: document.getElementById('newServiceStatus').value
                });

                const response = await fetch(`/port?${params}`, {
                    method: 'GET'
                });

                const contentType = response.headers.get('content-type') || '';
                let result;

                if (contentType.includes('application/json')) {
                    result = await response.json();
                } else {
                    const text = await response.text();
                    result = {
                        success: response.ok,
                        message: text,
                        errors: []
                    };
                }

                if (result.success) {
                    responseDiv.className = 'success';
                    responseDiv.innerHTML = `<h3>Success!</h3><p>${result.message}</p>`;
                } else {
                    responseDiv.className = 'error';
                    responseDiv.innerHTML = `
                        <h3>Error (HTTP ${response.status})</h3>
                        <p>${result.message}</p>
                        ${result.errors?.length ? `
                        <h4>Errors:</h4>
                        <ul>
                            ${result.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                        ` : ''}
                    `;
                }
            } catch (error) {
                responseDiv.className = 'error';
                responseDiv.innerHTML = `
                    <h3>Request Failed!</h3>
                    <p>${error.message}</p>
                    <p>Check console for details</p>
                `;
                console.error('Status update failed:', error);
            }
        });
    </script>


</body>
</html>
