<?php

namespace spec\Bernard\ServiceResolver;

require_once __DIR__ . '/../../fixtures/Uploader.php';

class InvocatorSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param spec\fixtures\Uploader $service
     * @param Bernard\Message $message
     */
    function let($service, $message)
    {
        $this->beConstructedWith($service, $message);
    }

    function it_prefix_method_name_and_uppercase_first_letter($message)
    {
        $message->getName()->willReturn('UploadImage', 'Sendnewsletter', 'importUsers');

        $this->getMethodName()->shouldReturn('onUploadImage');
        $this->getMethodName()->shouldReturn('onSendnewsletter');
        $this->getMethodName()->shouldReturn('onImportUsers');
    }

    function it_invokes_method_on_service_service_with_message_as_argument($service, $message)
    {
        $message->getName()->willReturn('UploadImage');

        $service->onUploadImage($message)->shouldBeCalledTimes(2);

        $this->invoke();
        $this();
    }
}
