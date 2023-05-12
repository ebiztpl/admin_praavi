<?php

namespace App\Http\Requests\Leave;

use App\Models\Leave\Type;
use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
{
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
        return [
            'name' => 'required|min:2|max:100',
            'alias' => 'nullable|min:2|max:100',
            'description' => 'nullable|min:2|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('leave_type.uuid');

            $existingNames = Type::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereName($this->name)
                ->exists();

            if ($existingNames) {
                $validator->errors()->add('name', trans('validation.unique', ['attribute' => __('leave.type.type')]));
            }

            if (! $this->alias) {
                return;
            }

            $existingAliases = Type::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereAlias($this->alias)
                ->exists();

            if ($existingAliases) {
                $validator->errors()->add('alias', trans('validation.unique', ['attribute' => __('leave.type.type')]));
            }
        });
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('leave.type.props.name'),
            'alias' => __('leave.type.props.alias'),
            'description' => __('leave.type.props.description'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
