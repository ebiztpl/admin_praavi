<?php

namespace App\Services\Attendance;

use App\Enums\Attendance\Category as AttendanceCategory;
use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Record as AttendanceRecord;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TypeService
{
    public function preRequisite(Request $request): array
    {
        $attendanceCategories = AttendanceCategory::getOptions();

        return compact('attendanceCategories');
    }

    public function create(Request $request): AttendanceType
    {
        \DB::beginTransaction();

        $attendanceType = AttendanceType::forceCreate($this->formatParams($request));

        \DB::commit();

        return $attendanceType;
    }

    private function formatParams(Request $request, ?AttendanceType $attendanceType = null): array
    {
        $formatted = [
            'name' => $request->name,
            'code' => $request->code,
            'color' => $request->color,
            'category' => $request->category,
            'unit' => AttendanceCategory::isProductionBased($request->category) ? AttendanceProductionUnit::HOURLY->value : null,
            'alias' => $request->alias,
            'description' => $request->description,
        ];

        if (! $attendanceType) {
            $formatted['team_id'] = session('team_id');
        }

        return $formatted;
    }

    public function update(Request $request, AttendanceType $attendanceType): void
    {
        if ($request->category != $attendanceType->category) {
            $existingAttendance = Attendance::whereAttendanceTypeId($attendanceType->id)->exists();
            $productionAttendanceExists = AttendanceRecord::whereAttendanceTypeId($attendanceType->id)->exists();

            if ($existingAttendance || $productionAttendanceExists) {
                throw ValidationException::withMessages(['message' => trans('attendance.type.could_not_perform_if_attendance_is_marked')]);
            }
        }

        \DB::beginTransaction();

        $attendanceType->forceFill($this->formatParams($request, $attendanceType))->save();

        \DB::commit();
    }

    public function deletable(AttendanceType $attendanceType): void
    {
        $attendanceExists = Attendance::whereAttendanceTypeId($attendanceType->id)->exists();

        if ($attendanceExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('attendance.type.type'), 'dependency' => trans('attendance.attendance')])]);
        }

        $productionAttendanceExists = AttendanceRecord::whereAttendanceTypeId($attendanceType->id)->exists();

        if ($productionAttendanceExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('attendance.type.type'), 'dependency' => trans('attendance.attendance')])]);
        }
    }
}
