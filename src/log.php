<?php

namespace timber;

use \Requests;

class log{

    private $messages = array();
    private $source_id;
    private $source_apikey;

    const INFO    = 'info';
    const WARNING = 'warning';
    const ERROR   = 'error';
    const DEBUG   = 'debug';

    public function __construct( $source_id, $source_apikey ){
        $this->source_id = $source_id;
        $this->source_apikey = $source_apikey;
    }

    public function & info( $message, $meta = null, $timestamp = null ){
        $this->messages[] = $this->message( log::INFO, $message, $meta, $timestamp );
        return $this;
    }

    public function & warning( $message, $meta = null, $timestamp = null ){
        $this->messages[] = $this->message( log::WARNING, $message, $meta, $timestamp );
        return $this;
    }

    public function & error( $message, $meta = null, $timestamp = null ){
        $this->messages[] = $this->message( log::ERROR, $message, $meta, $timestamp );
        return $this;
    }

    public function & debug( $message, $meta = null, $timestamp = null ){
        $this->messages[] = $this->message( log::DEBUG, $message, $meta, $timestamp );
        return $this;
    }

    public function send(){
        return $this->post( $this->messages );
    }

    public function message( $level, $message, $meta, $timestamp ){
        return json_encode( array( "level" => $level, "message" => $message, 'dt' => ( is_null( $timestamp ) ? date( sprintf( 'Y-m-d\TH:i:s%s\Z', substr( microtime(), 1, 6 ) ) ) : $timestamp ) ) + ( is_array( $meta ) ? $meta : array() ) );
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
