# PhpMysql-Crud-Active-Campaign
CRUD for Active Campaign with php and Mysql

<p>This code contains:
    <ul>
        <li>an API for add, retrieve, update and delete a Contact on Active Campaign Plataform</li>
        <li>a Webhook that memorizes some data into Database's Table "Log" when a new Contact is added and it creates a log file too (webhooks.log file)</li>
        <li>a Stored Procedure that checks if user's phone numbers are null</li>
        <li>a Trigger that insert a user's email into Table "wellcome_gift" when a new Contact is added</li>
        <li>a Dump of Database (in /db/sql_dump.sql) to load before run code</li>
    </ul>
</p>
<br /><br />
<p>Data to modify first to run the code:
    <br /> const URL_DEV = "https://<your-account>.api-us1.com/api/3";  // Insert your personal data
    <br /> const API_TOKEN = "<Insert your API TOKEN>"; // Insert your personal data

    <br />
    // Insert data of your Database
    const HOST = "";
    const DB_NAME  = "";
    const USERNAME = "";
    const PASSWORD = "";
</p>
