<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIR Data Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image:url('phpback.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #data-container {
            text-align: center;
            color:#960018; /* Text color */
            font-weight: bold; /* Bold text */
            font-size: 3.5em; /* Adjust font size as needed */
            padding: 20px;
            /* background-color: rgba(0, 0, 0, 0.5); Semi-transparent background */
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div id="data-container">
        <?php

        $channelID = 2489757;
        $readAPIKey = "3NJBZ896N5VTBHDE";

        // Fetch data from ThingSpeak
        $url = "https://api.thingspeak.com/channels/$channelID/feeds/last.json?api_key=$readAPIKey";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data && isset($data['field1'])) {
            // Extract relevant data
            $pirData = $data['field1'];

            // Define threshold
            $threshold = 500; // Adjust this threshold based on your observations

            // Determine if motion is detected based on threshold
            if ($pirData > $threshold) {
                echo "Yes!! Faculty  is  available"; // Motion detected
            } else {
                echo "No, Faculty  is  not  available  right  now"; // No motion detected
            }
        } else {
            echo "Failed to fetch data from ThingSpeak";
        }

        ?>
    </div>
</body>
</html>
