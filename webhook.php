<?php
  // This Webhook memorizes some data into Database's Table "Log" when a new Contact is added 
  // and it creates a log file too

  const HOST = "";
  const DB_NAME  = "";
  const USERNAME = "";
  const PASSWORD = "";

  
  if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['type'] == 'subscribe'){
    $type_active_campaign = $_POST['type'];
    $date_time = $_POST['date_time'];
    $initiated_by	= $_POST['initiated_by'];
    $contact_id = $_POST['contact']['id'];
    $contact_email	= $_POST['contact']['email'];
    $contact_first_name = $_POST['contact']['first_name'];
    $contact_last_name	= $_POST['contact']['last_name'];
    $contact_phone	= $_POST['contact']['phone'];
    $contact_ip = $_POST['contact']['ip'];

    $conn = new PDO("mysql:host=".HOST.";dbname=".DB_NAME, USERNAME, PASSWORD);
    $statement = $conn->prepare('INSERT INTO logs (type_active_campaign, date_time, initiated_by, contact_id, contact_email, contact_first_name, contact_last_name, contact_phone, contact_ip) 
                VALUES (:type_active_campaign, :date_time, :initiated_by, :contact_id, :contact_email, :contact_first_name, :contact_last_name, :contact_phone, :contact_ip)');
    
    $statement->execute([
        'type_active_campaign' => $type_active_campaign, 
        'date_time' => $date_time, 
        'initiated_by' => $initiated_by, 
        'contact_id' => $contact_id, 
        'contact_email' => $contact_email, 
        'contact_first_name' => $contact_first_name, 
        'contact_last_name' => $contact_last_name, 
        'contact_phone' => $contact_phone, 
        'contact_ip' => $contact_ip
    ]);

    // Create a log file
    $data = print_r($_POST, 1);
    $fd = @fopen("./webhooks.log", "a");
    fwrite($fd, $data);
    fclose($fd); 
  }
?>