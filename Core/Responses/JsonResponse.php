<?php
/**
 * Created by PhpStorm.
 * User: MatiusDevelopment
 * Date: 10.11.2019
 * Time: 21:01
 */

namespace Core\Responses;


class JsonResponse
{
    private $_response;
    public function __construct($value)
    {
        header('Content-Type:application/json');
        header('Access-Control-Allow-Origin:*');
        $this->_response = json_encode($value);
        die($this->_response);
    }
}