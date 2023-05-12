<?php

namespace App\Services\Attendance;

use App\Concerns\SubordinateAccess;
use App\Contracts\ListGenerator;
use App\Http\Resources\Attendance\TimesheetResource;
use App\Models\Attendance\Timesheet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class TimesheetListService extends ListGenerator
{
    use SubordinateAccess;

    protected $allowedSorts = ['created_at', 'date', 'in_at', 'out_at'];

    protected $defaultSort = 'date';

    protected $defaultOrder = 'desc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'employee',
                'label' => trans('employee.employee'),
                'print_label' => 'employee.name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'designation',
                'label' => trans('company.designation.designation'),
                'print_label' => 'employee.designation',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'branch',
                'label' => trans('company.branch.branch'),
                'print_label' => 'employee.branch',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'workShift',
                'label' => trans('attendance.work_shift.work_shift'),
                'print_label' => 'work_shift.name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'date',
                'label' => trans('attendance.timesheet.props.date'),
                'print_label' => 'date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'inAt',
                'label' => trans('attendance.timesheet.props.in_at'),
                'print_label' => 'in_at_time_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'outAt',
                'label' => trans('attendance.timesheet.props.out_at'),
                'print_label' => 'out_at_time_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'duration',
                'label' => trans('attendance.timesheet.props.duration'),
                'print_label' => 'duration',
                'sortable' => false,
                'visibility' => true,
            ],
        ];

        if (request()->ajax()) {
            $headers[] = $this->actionHeader;
        }

        return $headers;
    }

    public function filter(Request $request): Builder
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployee();

        $employees = Str::toArray($request->query('employees'));

        return Timesheet::query()
            ->with(['employee' => fn ($q) => $q->withSummaryRecord(), 'workShift'])
            ->whereHas('employee', function ($q) use ($accessibleEmployeeIds, $employees) {
                $q->whereIn('id', $accessibleEmployeeIds)->when($employees, function ($q) use ($employees) {
                    $q->whereIn('uuid', $employees);
                });
            })
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\DateBetween:start_date,end_date,date',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return TimesheetResource::collection($this->filter($request)
                ->orderBy($this->getSort(), $this->getOrder())
                ->paginate((int) $this->getPageLength(), ['*'], 'current_page'))
        ->additional([
            'headers' => $this->getHeaders(),
            'meta' => [
                'allowed_sorts' => $this->allowedSorts,
                'default_sort' => $this->defaultSort,
                'default_order' => $this->defaultOrder,
            ],
        ]);
    }

    public function list(Request $request): AnonymousResourceCollection
    {
        return $this->paginate($request);
    }
}
