<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-14
 * Time: 00:10
 */

namespace App\Http\Requests;

trait AuthorizeForRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 認可はチェックしないので常にtrue
    }
}