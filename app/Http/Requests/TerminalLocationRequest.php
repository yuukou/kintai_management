<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-11
 * Time: 18:51
 */

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;

class TerminalLocationRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
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
            //メインかサブか
            'workspace_type' => [
                'required',
                'boolean',
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

    # responseを上書きする
    # ajax,jsonで返答時以外は親に流す
    /**
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse(['message' => '端末位置情報の登録に問題がありました。','errors'=>$errors], 422);
        }

        parent::response($errors);
    }
}