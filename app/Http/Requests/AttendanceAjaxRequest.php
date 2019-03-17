<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-15
 * Time: 10:55
 */

namespace App\Http\Requests;


class AttendanceAjaxRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            // 緯度
            'latitude' => [
                'required',
                'numeric',
                'regex:/^[0-8]?[0-9]\.?[0-9]{0,15}|90\.0{0,15}$/',
            ],
            // 経度
            'longitude' => [
                'required',
                'numeric',
                'regex:/^([1][0-7][0-9]|[0-9]?[0-9])\.[0-9]{0,15}|180\.0{0,15}?$/'
            ],
            //住所
            'address' => [
                'string',
                'required'
            ],
            //端末情報
            'terminal' => [
                'string',
                'required'
            ],
        ];
        return $rules;
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function attributes()
    {
        return trans('form.attributes');
    }
}