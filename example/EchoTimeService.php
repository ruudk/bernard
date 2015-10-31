<?php

use Bernard\Message\DefaultMessage;

class EchoTimeService
{
    public function echoTime(DefaultMessage $message)
    {
        echo "Message produced at " . date('H:i:s', $message->get('time')) . "\n";
        echo "Executed at " . date('H:i:s') . "\n\n";
    }
}
