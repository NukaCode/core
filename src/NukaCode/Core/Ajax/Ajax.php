<?php namespace NukaCode\Core\Ajax;

class Ajax {

    protected static $ajaxInstance;

    /**
     * The status of this ajax request.
     */
    public $status = 'error';

    /**
     * A list of the errors in this ajax request
     */
    public $errors = array();

    /**
     * A list of the data in this ajax request
     */
    public $data = array();

    public function __construct()
    {
        if (!isset(static::$ajaxInstance)) {
            static::$ajaxInstance = $this;
        }
    }

    public function get()
    {
        return static::$ajaxInstance;
    }

    /**
     * Add data to the json response
     *
     * @param  string $dataKey
     * @param  string $dataValue
     *
     * @return Utility_Response_Ajax
     */
    public function addData($dataKey, $dataValue)
    {
        static::$ajaxInstance->data[$dataKey] = $dataValue;

        return static::$ajaxInstance;
    }

    /**
     * Add more than one error to the ajax response
     *
     * @param  array $errors
     *
     * @return Utility_Response_Ajax
     */
    public function addErrors(array $errors)
    {
        static::$ajaxInstance->errors = array_merge($this->errors, $errors);

        return static::$ajaxInstance;
    }

    /**
     * Add an error to the ajax response
     *
     * @param  string $errorKey
     * @param  string $errorMessage
     *
     * @return Utility_Response_Ajax
     */
    public function addError($errorKey, $errorMessage)
    {
        static::$ajaxInstance->errors[$errorKey] = $errorMessage;

        return static::$ajaxInstance;
    }

    /**
     * Get the correct response errors
     *
     * @return array
     */
    public function getErrors()
    {
        return static::$ajaxInstance->errors;
    }

    /**
     * count the errors in the current response
     *
     * @return int
     */
    public function errorCount()
    {
        return count(static::$ajaxInstance->errors);
    }

    /**
     * Set the response status
     *
     * @param  string $newStatus
     *
     * @return Utility_Response_Ajax
     */
    public function setStatus($newStatus)
    {
        static::$ajaxInstance->status = $newStatus;

        return static::$ajaxInstance;
    }

    /**
     * get the response status
     *
     * @return string
     */
    public function getStatus()
    {
        return static::$ajaxInstance->status;
    }

    /**
     * Convert this object to a json response and send it
     *
     * @return Response
     */
    public function sendResponse()
    {
        return Response::json(static::$ajaxInstance);
    }
}