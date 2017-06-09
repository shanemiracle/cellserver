<?php
/**
 * Created by PhpStorm.
 * User: HC
 * Date: 2017/1/10
 * Time: 10:40
 */
namespace app\index\tool;

class RawClient
{
    /*
     *  Connect client to server
     * send message
     *
     * */
    private $socket = null;
    private $host='';
    private $timeout = 1;
    private $port=0;

    /**
     * Swooleclient constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port, $timeout=5)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        if($this->socket){
            socket_close($this->socket);
            $this->socket = null;
        }
    }

    /**
     * Swooleclient constructor.
     */


    public function send($byte)
    {
        if( !$this->is_connection() ) {
            $this->socket = $this->connect();
        }

        if( $this->socket == null ) {
            return false;
        }

        $sendBuf = $this->sendPack($byte);

        if( $sendBuf ) {
            $sendret = socket_write( $this->socket,$sendBuf);
            if(!$sendret)
            {
                return false;
            }
            return $this->recv();
        }

        return false;

    }

        /*
         * receive message from server
         * @return $reply
         * */
     public function recv( )
        {
           if($this->socket){
               $ret_s = '';
               for($i = 0; $i < 20; $i++){
                   $receive = socket_read($this->socket, 65535);
                   if ($receive){

                       $ret_s .= $receive;

                       //head;
                       $a = substr($ret_s,0,1);
                       if($a!='x'){
                           break;
                       }
                       if(substr($ret_s,1,1)!='i'){
                           break;
                       }
                       if(substr($ret_s,2,1)!='a'){
                           break;
                       }
                       if(substr($ret_s,3,1)!='o'){
                           break;
                       }

                       $len = 0;
                       $len_arry = unpack('n',substr($ret_s,4,2));
                       if($len_arry) {
                           $len =$len_arry['1'];
                       }

                       if($len>65535||$len ==0){
                           break;
                       }

                       if(strlen($ret_s) < $len+10) {
                           continue;
                       }

                       if(substr($ret_s,6+$len,1)!='c'){
                           break;
                       }
                       if(substr($ret_s,7+$len,1)!='o'){
                           break;
                       }
                       if(substr($ret_s,8+$len,1)!='d'){
                           break;
                       }
                       if(substr($ret_s,9+$len,1)!='e'){
                           break;
                       }

                       $ret_ok = substr($ret_s,6,$len);

                       return $ret_ok;
                   }
                   else {
                       break;
                   }
               }
           }
            $this->socket = null;
            return false;
        }

    private function is_connection() {
        if($this->socket) {
            $ret = socket_write($this->socket,' ',1);
            if ($ret) {
                return true;
            }
            else {
                socket_close($this->socket);
                $this->socket = null;
                return false;
            }
        }
        else {
            return false;
        }
    }
    /*
     * create socket
     * @return $socket
     * */
    private function connect($timeout=1){
        //创建socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!is_resource($socket)) {
            echo 'Unable to create socket: '. socket_strerror(socket_last_error()) . PHP_EOL;
        }
        //连接服务器端socket
        if($socket) {
            if(!socket_set_option($socket,SOL_SOCKET,SO_REUSEADDR,1)){
                return false;
            }

            if(!socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array('sec'=>$this->timeout,'usec'=>0))){
                return false;
            }
            $connection = socket_connect($socket, $this->host, $this->port);
            if ($connection)
            {
                return $socket;
            }
        }
        return null;
    }

    private function sendPack( $data ) {
        $buf = new Byte();
        if( $buf ) {
            $buf->writeChar('xiao');
            $buf->writeShortInt( strlen($data) );
            $buf->writeChar( $data );
            $buf->writeChar('code');
            $buf=$buf->getByte();
            return $buf;
        }
        return false;
    }


}