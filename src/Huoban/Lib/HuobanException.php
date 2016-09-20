<?php
/**
 * HuobanException
 *
 * $Id$
 */
namespace Huoban\Lib;

class HuobanException extends \Exception {

    private $details = array();

    function __construct($details)
    {
        if (is_array($details)) {
            $message = $details['code'] . ': ' . $details['message'];
            parent::__construct($message);
            $this->details = $details;
        } else {
            $message = $details;
            parent::__construct($message);
        }
    }

    public function getErrorCode()
    {
        return isset($this->details['code']) ? $this->details['code'] : '';
    }

    public function getErrorMessage()
    {
        return isset($this->details['message']) ? $this->details['message'] : '';
    }

    public function getErrors()
    {
        return isset($this->details['errors']) ? $this->details['errors'] : '';
    }
}
