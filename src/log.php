<?php

namespace timber;

use \Requests;

class log{

    private $messages = array();
    private $source_id;
    private $source_apikey;

    public function __construct( $source_id, $source_apikey ){
        $this->source_id = $source_id;
        $this->source_apikey = $source_apikey;
    }

    public function info( $message, $meta = null, $timestamp = null ){
        $message = $this->message( 'info', $message, $meta, $timestamp );
        $this->messages[] = $message;
        return $message;
    }

    public function warning( $message, $meta = null, $timestamp = null ){
        $message = $this->message( 'warning', $message, $meta, $timestamp );
        $this->messages[] = $message;
        return $message;
    }

    public function error( $message, $meta = null, $timestamp = null ){
        $message = $this->message( 'error', $message, $meta, $timestamp );
        $this->messages[] = $message;
        return $message;
    }

    public function debug( $message, $meta = null, $timestamp = null ){
        $message = $this->message( 'debug', $message, $meta, $timestamp );
        $this->messages[] = $message;
        return $message;
    }

    public function message( $level, $message, $meta, $timestamp ){
        return json_encode( array( "level" => $level, "message" => $message ) + ( is_array( $meta ) ? $meta : array() ) + ( is_null( $timestamp ) ? array() : array( 'dt' => date( 'c', $timestamp ) ) ) );
    }

    public function send(){
        return $this->post( $this->messages );
    }

    public function post( $messages ){

        $headers = array(
            'Authorization' => 'Bearer ' . $this->source_apikey,
            'Content-Type' => 'application/ndjson'
        );

        $message = implode( "\n", $messages );

        $req = Requests::post( 'https://logs.timber.io/sources/' . $this->source_id . '/frames', $headers, $message );

        return $req->status_code == 202;
    }

}
