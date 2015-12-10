<?php
/**
 * Created by PhpStorm.
 * User: zhoujia05
 * Date: 2015/12/7
 * Time: 16:28
 */

namespace App\OAuth\ResponseModel;

use Illuminate\Contracts\Support\Arrayable;

/**
 * 基础的Oauth响应类
 * Class BaseResponse
 * @package App\OAuth\ResponseModel
 */
class BaseResponse implements Arrayable
{
    protected $errcode;
    protected $errmsg;
    protected $data;



    /**
     * BaseResponse constructor.
     * @param $errcode
     * @param $errmsg
     * @param $data
     */
//    public function __construct($errcode, $errmsg, $data)
//    {
//        $this->errcode = $errcode;
//        $this->errmsg = $errmsg;
//        $this->data = $data;
//    }

    /**
     * @return mixed
     */
    public function getErrcode()
    {
        return $this->errcode;
    }

    /**
     * @param mixed $errcode
     */
    public function setErrcode($errcode)
    {
        $this->errcode = $errcode;
    }

    /**
     * @return mixed
     */
    public function getErrmsg()
    {
        return $this->errmsg;
    }

    /**
     * @param mixed $errmsg
     */
    public function setErrmsg($errmsg)
    {
        $this->errmsg = $errmsg;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
        $varArray = get_object_vars($this);
        return $varArray;
    }
}