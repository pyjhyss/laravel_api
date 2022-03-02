<?php

namespace Pyjhyssc\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Pyjhyssc\Exceptions\ApiRequestExcept;

class BaseRequest extends FormRequest
{
    //规则
    public array $rules = [];
    //场景
    public array $scene = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
        $rules = method_exists($this, 'setRules') ? $this->setRules() : $this->rules;
        if (!$this->scene) {
            return $this->rules;
        }

        $action = request()->route()->getActionMethod();
        if (!isset($this->scene[$action])) {
            return [];
        }

        return Arr::only($rules, $this->scene[$action]);
    }


    public function getParam()
    {
        if ($this->scene) {
            $action = request()->route()->getActionMethod();
            if (isset($this->scene[$action])) {
                return $this->only($this->scene[$action]);
            }
        }
        return $this->only(array_keys($this->rules));
    }

    /**
     * @throws ApiRequestExcept
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ApiRequestExcept($validator->errors()->first());
    }
}
