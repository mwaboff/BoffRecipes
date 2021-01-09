<?php

class ApplicationResult {

    function __construct($success=true, $error_type="", $error_message="") {
        $this->success = $success;
        $this->error_type = $error_type;
        $this->error_message = $error_message;
    }

    function reset() {
        $this->success = true;
        $this->error_type = "";
        $this->error_message = "";
    }

    function isSuccess() {
        return $this->success;
    }

    function setSuccess() {
        $this->success = true;
    }

    function setFailure() {
        $this->success = false;
    }

    function setErrorType($new_type) {
        $this->error_type = $new_type;
    }

    function setErrorMessage($new_message) {
        $this->error_message = $new_message;
    }

    function __toString() {
        $result = "";
        if (!$this->success) {
            $result = "ERROR: $this->error_type: $this->error_message";
        }
        return $result;
    }
}


?>