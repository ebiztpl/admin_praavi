<?php

namespace App\Http\Requests\Attendance;

use App\Enums\Attendance\Category as AttendanceCategory;
use App\Models\Attendance\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
        $rules = [
            'name' => 'required|min:2|max:100',
            'code' => 'required|min:1|max:10|alpha',
            'color' => 'required',
            'alias' => 'nullable|min:2|max:100',
            'category' => ['required', new Enum(AttendanceCategory::class)],
            'description' => 'nullable|min:2|max:1000',
        ];

        if (AttendanceCategory::isProductionBased($this->category)) {
            // $rules['unit'] = 'required|min:1|max:50';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('attendance_type.uuid');

            $existingNames = Type::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereName($this->name)
                ->exists();

            if ($existingNames) {
                $validator->errors()->add('name', trans('validation.unique', ['attribute' => __('attendance.type.type')]));
            }

            if (in_array($this->code, ['L'])) {
                $validator->errors()->add('code', trans('validation.reserved', ['attribute' => __('attendance.type.type')]));
            }

            $existingCodes = Type::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereCode($this->code)
                ->exists();

            if ($existingCodes) {
                $validator->errors()->add('code', trans('validation.unique', ['attribute' => __('attendance.type.type')]));
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
                $validator->errors()->add('alias', trans('validation.unique', ['attribute' => __('attendance.type.type')]));
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
            'name' => __('attendance.type.props.name'),
            'alias' => __('attendance.type.props.alias'),
            'color' => __('attendance.type.props.color'),
            'description' => __('attendance.type.props.description'),
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
