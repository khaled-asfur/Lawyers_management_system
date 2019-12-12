<?php 
class DBConnect{
    private static  $connected =false;
    private static  $conn ;
    
   /* private static $servername = "localhost";
    private static $username = "root";
    private static $password = "lool";
    private static $dbname = "lawyers_website";
    */
    
    private static $servername = "khalidasfur07411.ipagemysql.com";
    private static $username = "lawyer";
    private static $password = "lool";
    private static $dbname = "lawyers_website1";
    

    //connect and return the connection variable
    private static function  connectDB(){
        if(!self::$connected){
        self::$conn = mysqli_connect(self::$servername, self::$username, self::$password, self::$dbname);
        //مشان اضيف عالداتا بيز نص عربي ، بدونه بصير اضيف رموز مش مفهوومة 
        self::$conn->set_charset("utf8");
        self::$connected=true;
        }
        return self::$conn;
    }

    // close connection
    public static function  closeConnection(){
        self::$conn->close();
        self::$connected=false;
    }
    // check if variable conn is connected to db or not
   public static function  isConnected(){
        if($connected)
        return true;
        else
        return false;
    }

    // اذا كنت متصل على الداتا بيز برجع الفاريابل كوننيكشن واذا مش متصل بتصل عالداتا بيز وبرجع الفاريابل كوننيكشن
    public static function getConnection(){
        if(self::$connected){
            return self::$conn;
        }

        else 
            self::connectDB();
        return self::$conn;
        
    }

}
?>