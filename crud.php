<?php
    /* 
        This is the class Contact, used to memorize user's data
        You can find all references here: https://developers.activecampaign.com/reference#contact
    
    */
    
    class Contact {
        public $email;
        public $firstName;
        public $lastName;
        public $phone;

        const URL_DEV = "https://<your-account>.api-us1.com/api/3";  // Insert your personal data
        const API_TOKEN = "<Insert your API TOKEN>"; // Insert your personal data

        
        // Insert data of your Database
        const HOST = "";
        const DB_NAME  = "";
        const USERNAME = "";
        const PASSWORD = "";

               
        // Add New Contact
        // Reference: https://developers.activecampaign.com/reference#create-a-contact-new
        function __construct($email, $firstName = "", $lastName = "", $phone = 0){
            if($email == null) return;

            $this->email = $email;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->phone = $phone;

            $data = array("email" => $this->email, "firstName" => $this->firstName, "lastName" => $this->lastName, "phone" => $this->phone);
            $postdata = json_encode(array("contact" => $data));

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => self::URL_DEV."/contacts",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Api-Token: ".self::API_TOKEN
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err){
                echo "Error with adding new Contact:" . $err;
            } else {
                echo "<h2>New Contact inserted with success!<h2>";

                // Insert new Contact into TABLE "check_phone" to control if exists her phone
                // and the TRIGGER insert this Contact into TABLE "wellcome_gift" to do a gift at Customer
                try{
                    $conn = new PDO("mysql:host=".self::HOST.";dbname=".self::DB_NAME, self::USERNAME, self::PASSWORD);
                     
                    $statement = $conn->prepare('INSERT INTO check_phone (email, phone) VALUES (:email, :phone)');

                    $statement->execute([
                        'email' => $this->email,
                        'phone' => $this->phone
                    ]);
                } catch (PDOException $pe) {
                    die("Could not connect to the database:" . $pe->getMessage());
                }
            }
        }

        //Retrieve an existing contact
        // Reference: https://developers.activecampaign.com/reference#get-contact
        public static function retrieve_contact($contact_id){
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => self::URL_DEV."/contacts/".$contact_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Api-Token: ".self::API_TOKEN
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err){
                echo "Error with retrieving a Contact:" . $err;
            } else {
                echo "<br><h2>User data - ID = $contact_id</h2>";
                $contact_found = json_decode($response, true);
                echo "Firstname: ".$contact_found['contact']['firstName'];
                echo "<br>Lastname: ".$contact_found['contact']['lastName'];
                echo "<br>Email: ".$contact_found['contact']['email'];
                echo "<br>Phone: ".$contact_found['contact']['phone'];
            }
        }

        // Update a Contact
        // Reference: https://developers.activecampaign.com/reference#update-a-contact-new
        function update_contact($contact_id, $update_values){
            $data = array();

            if($update_values->email != ''){
                $data['email'] = $update_values->email;
            }

            if($update_values->firstName != ''){
                $data['firstName'] = $update_values->firstName;
            }

            if($update_values->lastName != ''){
                $data['lastName'] = $update_values->lastName;
            }

            if($update_values->phone != ''){
                $data['phone'] = $update_values->phone;
            }

            if($update_values->fieldValues != ''){
                $data['fieldValues'] = $update_values->fieldValues;
            }

           
            $postdata = json_encode(array("contact" => $data));

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => self::URL_DEV."/contacts/".$contact_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Api-Token: ".self::API_TOKEN
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err){
                echo "Error with updating a contact:" . $err;
            } else {
                echo "<br><h2>Updated User data - ID = $contact_id</h2>";
                $contact_found = json_decode($response, true);
                echo "Firstname: ".$contact_found['contact']['firstName'];
                echo "<br>Lastname: ".$contact_found['contact']['lastName'];
                echo "<br>Email: ".$contact_found['contact']['email'];
                echo "<br>Phone: ".$contact_found['contact']['phone']; 
            }
        }

        // Delete a Contact
        function delete_contact($contact_id){
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => self::URL_DEV."/contacts/".$contact_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Api-Token: ".self::API_TOKEN
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err){
                echo "Error with deleting Contact:" . $err;
            } else {
                echo "<br><h2>Deleted Contact with ID = $contact_id</h2>";
            }
        }

        //Show the Contacts without Phone Number using "GetPhoneContactNull() Stored Procedure"
        public static function check_phone_null_contact(){
            try{
                $conn = new PDO("mysql:host=".self::HOST.";dbname=".self::DB_NAME, self::USERNAME, self::PASSWORD);
                
                $sql = 'CALL GetPhoneContactNull()';
                $q = $conn->query($sql);
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $null_phone_contacts = $q->fetch();

                echo "There are ".$null_phone_contacts['totalNullPhone']." null phone contacts";

            } catch (PDOException $pe) {
                die("Could not connect to the database:" . $pe->getMessage());
            }
        }

        function set_email($email) {
          $this->email = $email;
        }

        function get_email() {
          return $this->email;
        }

        function set_firstName($firstName) {
           $this->firstName = $firstName;
        }
  
        function get_firstName() {
           return $this->firstName;
        }

        function set_lastName($lastName) {
            $this->lastName = $lastName;
        }
   
        function get_lastName() {
            return $this->lastName;
        }

        function set_phone($phone) {
            $this->phone = $phone;
        }
   
        function get_phone() {
            return $this->phone;
        }
    }

      
    
      # EXAMPLES

      # Insert a new Contact
      //$new_contact = new Contact("email.com", "firstName", "lastName", "phone");
   
      # Check Null Phone Number 
      //Contact::check_phone_null_contact(); 

      # Find an Contact by ID
      //Contact::retrieve_contact(1);
      
      # Delete a Contact By ID
      //Contact::delete_contact(6); 

    
      #Update a Contact 
       /*
            $update_values = new stdClass();
            $update_values->email = '';
            $update_values->firstName = '';
            $update_values->lastName = '';
            $update_values->phone = '';
            

            $field1 = new stdClass();
            $field2 = new stdClass();

            $field1->field = "";
            $field1->value = "";

            $field2->field = "";
            $field2->value = "";

            $field_values_array = array($field1, $field2);

            $update_values->fieldValues = $field_values_array;

            
            (new Contact(null))->update_contact(1, $update_values); 
        */
        
      
?>