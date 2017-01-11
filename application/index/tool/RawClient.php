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
    static $socket = null;
    private $host='';
    private $port=0;

    /**
     * Swooleclient constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Swooleclient constructor.
     */


    public function send($byte)
    {
        if( !$this->is_connection() ) {
            RawClient::$socket = $this->connect();
        }

        if( RawClient::$socket == null ) {
            return false;
        }

        $sendBuf = $this->sendPack($byte);

        if( $sendBuf ) {
            $send = socket_write( RawClient::$socket,$sendBuf);
            if(!$send)
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
           if(RawClient::$socket){
               $receive = socket_read(RawClient::$socket, 8129);
               if ($receive){
                   return $receive;
               }
           }
            RawClient::$socket = null;
            return null;
        }

    private function is_connection() {
        if(RawClient::$socket) {
            $ret = socket_write(RawClient::$socket,' ',1);
            if ($ret) {
                return true;
            }
            else {
                socket_close(RawClient::$socket);
                RawClient::$socket = null;
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
    private function connect(){
        //创建socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!is_resource($socket)) {
            echo 'Unable to create socket: '. socket_strerror(socket_last_error()) . PHP_EOL;
        }
        //连接服务器端socket
        if($socket) {
            if(!socket_set_option(RawClient::$socket,SOL_SOCKET,SO_RCVTIMEO,array('sec'=>3,'usec'=>0))){
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