<?php

// Start a Session
if( !session_id() ) @session_start();

// define some constants for the project
define('PROJECT_FOLDER', '/');
define('EMAIL_TO', 'alejandro.mohamad@gmail.com');

// load libraries through composer
require_once 'vendor/autoload.php';

WingCommander::init();

Flight::set('flight.base_url', PROJECT_FOLDER);

// load dotenv
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// routes
Flight::route('/', array('AcaSeDona\Home', 'index'));
Flight::route('POST /send-place', array('AcaSeDona\Home', 'save_place'));
Flight::route('/places', array('AcaSeDona\Home', 'display_places'));
// Flight::route('POST /send-mail', array('AcaSeDona\Contact', 'send'));

Flight::route('/backend/places', array('AcaSeDona\Backend', 'places'));
Flight::route('/backend/hide_place/@id', array('AcaSeDona\Backend', 'hide_place'));
Flight::route('GET /backend/place/@id', array('AcaSeDona\Backend', 'edit_place'));
Flight::route('POST /backend/place/@id', array('AcaSeDona\Backend', 'update_place'));

Flight::start();
