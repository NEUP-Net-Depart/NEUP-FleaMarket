<?php

// Copyright 2013 Leonardo Bartoli <leonardo.bartoli@gmail.com>.
// All rights reserved.
// This program comes with ABSOLUTELY NO WARRANTY;
// Use of this source code is governed by a free software license,
// for details visit http://www.gnu.org/licenses/lgpl.html

/*
  Simple PHP JsonRPC client through raw tcp connection.
  Socket connections follow lazy open pattern and are closed
  during object destruction.
 */
class JsonRpcException extends Exception {}

class JsonRpcClient {
  private $address;
  private $port;
  private $socket;

  public function __construct($address, $port) {
    $this->address = $address;
    $this->port = $port;
    $this->socket = false;
  }

  public function __desctructor() {
    if ($this->socket) {
      socket_close($this->socket);
    }
  }
  
  public function __open() {
    if (($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
      throw new  JsonRpcException("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
    }
  }
  
  private function generateId() {
    $chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    $id = '';
    for($c = 0; $c < 16; ++$c)
      $id .= $chars[mt_rand(0, count($chars) - 1)];
    return $id;
  }

  public function Call($name, $arguments=null) {
    $id = $this->generateId();

    $request = array(
                     'jsonrpc' => '2.0',
                     'method'  => $name,
                     'params'  => array($arguments),
                     'id'      => $id
                     );
    
    $jsonRequest = json_encode($request);

    echo $jsonRequest . PHP_EOL;
    $this->__open();

    socket_bind($this->socket, $this->address);
    if (!socket_connect($this->socket, $this->address, $this->port)) {
      throw new  JsonRpcException('unable to open socket', -32603);
    }
        
    socket_write($this->socket, $jsonRequest);
    $jsonResponse = socket_read($this->socket, 4096);

    if ($jsonResponse === false) {
      throw new  JsonRpcException('file_get_contents failed', -32603);
    }

    $response = json_decode($jsonResponse);
    if ($response === null) {
      throw new JsonRpcException('JSON cannot be decoded', -32603);
    }
        
    if ($response->id != $id) {
      throw new JsonRPCException('Mismatched JSON-RPC IDs', -32603);
    }

    if ($response->error) {
      throw new JsonRpcException($response->error);
    }

    if (property_exists($response, 'result')) {
      return $response->result;
    } else {
      throw new JsonRpcException('Invalid JSON-RPC response', -32603);
    }
  }
}

?>
