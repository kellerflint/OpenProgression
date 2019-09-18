<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Loaded Page</h1>

    <h1>
        <?php echo "PHP Worked";?>
    </h1>

    <h1>
        <?php 

        // Remember that in docker, the service name can be used for the ip on the virtual network
        define("DB_SERVER", "database");
        define("DB_USER", "root");
        define("DB_PASS", "password");
        define("DB_NAME", "makersite");

        $db = db_connect();
        $id = 2;
        $query = "SELECT * FROM Test WHERE test_id = ?";
        $stmt = $db->prepare($query);
        // You should have something checking if the prepare method returned false before attempting to bind. 
        // That's what the boolean bind error is about
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $set = $stmt->get_result();
        $stmt->close();

        while ($item = mysqli_fetch_assoc($set)) {
            echo $item['test_output'];
        }
        

        db_disconnect($db);

        function db_connect()
        {
            $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            return $connection;
        }
        function db_disconnect($connection)
        {
            if (isset($connection)) {
                $connection->close();
            }
        }
        
        ?>
    </h1>
</body>
</html>