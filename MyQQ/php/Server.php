<?php



class Server {

    protected $_request = NULL;
    protected $_response = NULL;
    protected $_con = false;

    public function __construct() {
        $this->makeSuccessResponse("unknown error", false);
    }

    public function __destruct() {
        
    }

    public function run() {
        
    }

    public function setRequest($request) {
        $this->_request = $request;
        $this->makeSuccessResponse(true,  $this->_request->params->username);
    }

    public function makeSuccessResponse($success, $message, $data = array()) {
        $this->_response = array(
            "success" => $success,
            "message" => $message,
            "data" => $data
        );
    }

    public function getResponse() {
        return $this->_response;
    }

    public function openConnection() {

        $constr = "host=127.0.0.1 port=5432 dbname=webgis user=postgres password=yaozp369";
        $con = pg_connect($constr);
        if (!$con) {
            $this->makeSuccessResponse(false, "Can't connect to DATABASE");
            return false;
        }
        $this->_con = $con;
        return true;
    }

    public function closeConnection() {
        if ($this->_con) {
            pg_close($this->_con);
            $this->_con = false;
        }
    }

}
