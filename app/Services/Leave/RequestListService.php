<?php

namespace App\Services\Leave;

use App\Concerns\SubordinateAccess;
use App\Contracts\ListGenerator;
use App\Http\Resources\Leave\RequestResource as LeaveRequestResource;
use App\Models\Leave\Request as LeaveRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class RequestListService extends ListGenerator
{
    use SubordinateAccess;

    protected $allowedSorts = ['created_at', 'start_date', 'end_date'];

    protected $defaultSort = 'created_at';

    protected $defaultOrder = 'desc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'employee',
                'label' => trans('employee.employee'),
                'print_label' => 'employee.full_name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'leaveType',
                'label' => trans('leave.type.type'),
                'print_label' => 'leave_type.name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'startDate',
                'label' => trans('leave.request.props.start_date'),
                'print_label' => 'start_date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'endDate',
                'label' => trans('leave.request.props.end_date'),
                'print_label' => 'end_date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'status',
                'label' => trans('leave.request.props.status'),
                'print_label' => 'status_display',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'createdAt',
                'label' => trans('general.created_at'),
                'sortable' => true,
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
        $leaveTypes = Str::toArray($request->query('leaveTypes'));

        return LeaveRequest::query()
            ->with(['employee' => fn ($q) => $q->withSummaryRecord(), 'type'])
            ->byTeam()
            ->whereHas('employee', function ($q) use ($accessibleEmployeeIds, $employees) {
                $q->whereIn('id', $accessibleEmployeeIds)->when($employees, function ($q) use ($employees) {
                    $q->whereIn('uuid', $employees);
                });
            })
            ->when($leaveTypes, function ($q, $leaveTypes) {
                $q->whereHas('type', function ($q) use ($leaveTypes) {
                    $q->whereIn('uuid', $leaveTypes);
                });
            })
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\DateBetween:start_date,end_date,start_date,end_date',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return LeaveRequestResource::collection($this->filter($request)
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
