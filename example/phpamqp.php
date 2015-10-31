<?php

use Bernard\Driver;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Must be defined before including bootstrap.php
 * as this is the only custom part in the example.
 */
function get_driver() {
    require_once 'DelayedPhpAmqpDriver.php';

    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

    return new DelayedPhpAmqpDriver($connection, 'my-exchange');
}

require 'bootstrap.php';
