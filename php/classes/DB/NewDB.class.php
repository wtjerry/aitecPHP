<?php



class NewDB{
    private static $instance;
    private $pdo;

    public function __construct(array $dbInfo) {
        try{
            $this->pdo = new PDO("mysql:host=".$dbInfo['db_host'].";dbname=".$dbInfo['db_name'].";", $dbInfo['db_user'], $dbInfo['db_pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $ex){
            throw new Exception("There is a problem with the DB connection sorry");
        }
    }
    public static function init($dbInfo=array('host'=>"localhost", 'db'=>"test", 'dbuser'=>"aitec", 'dbpass'=>"aitec")){
        if(!(self::$instance instanceof self)){
            self::$instance = new NewDB($dbInfo);
            return true;
        }
        return false;
    }
    public static function query($query, $values=array()){
        $prep = self::$instance->pdo->prepare($query);

        //Logger::info($query);

        if(!empty($values)) {
            $val = self::prepareValuesForQueryExecution($values);
            //Logger::info(count($values));
            //Logger::info($values[0]);
            $prep->execute($val);
        }
        else {
            $prep->execute();
        }
        return $prep;
    }
    public static function prepareValuesForQueryExecution($values){
        return array_map('htmlentities', $values);
    }
    public static function getInstance(){
        return self::$instance->pdo;
    }
}


?>