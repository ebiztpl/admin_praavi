<?php

namespace App\Services\Payroll;

use App\Concerns\SubordinateAccess;
use App\Contracts\ListGenerator;
use App\Http\Resources\Payroll\PayrollResource;
use App\Models\Payroll\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PayrollListService extends ListGenerator
{
    use SubordinateAccess;

    protected $allowedSorts = ['created_at', 'start_date', 'end_date', 'total', 'paid'];

    protected $defaultSort = 'created_at';

    protected $defaultOrder = 'desc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'codeNumber',
                'label' => trans('payroll.props.code_number'),
                'sortable' => false,
                'visibility' => true,
            ],
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
                'key' => 'startDate',
                'label' => trans('payroll.props.start_date'),
                'print_label' => 'start_date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'endDate',
                'label' => trans('payroll.props.end_date'),
                'print_label' => 'end_date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'total',
                'label' => trans('payroll.props.total'),
                'print_label' => 'total_display',
                'sortable' => true,
                'visibility' => true,
            ],
            // array(
            //     'key' => 'paid',
            //     'label' => trans('payroll.props.paid'),
            //     'print_label' => 'paid_display',
            //     'sortable' => true,
            //     'visibility' => true
            // ),
            // array(
            //     'key' => 'status',
            //     'label' => trans('payroll.props.status'),
            //     'print_label' => 'status_display',
            //     'sortable' => true,
            //     'visibility' => true
            // ),
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

        return Payroll::query()
            ->with(['employee' => fn ($q) => $q->withSummaryRecord()])
            ->whereHas('employee', function ($q) use ($accessibleEmployeeIds, $employees) {
                $q->whereIn('id', $accessibleEmployeeIds)->when($employees, function ($q) use ($employees) {
                    $q->whereIn('uuid', $employees);
                });
            })
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\DateBetween:start_date,end_date,start_date,end_date',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return PayrollResource::collection($this->filter($request)
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
