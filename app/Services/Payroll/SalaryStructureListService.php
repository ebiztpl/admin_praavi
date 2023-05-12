<?php

namespace App\Services\Payroll;

use App\Concerns\SubordinateAccess;
use App\Contracts\ListGenerator;
use App\Http\Resources\Payroll\SalaryStructureResource;
use App\Models\Payroll\SalaryStructure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class SalaryStructureListService extends ListGenerator
{
    use SubordinateAccess;

    protected $allowedSorts = ['created_at', 'effective_date', 'net_earning', 'net_deduction', 'net_salary'];

    protected $defaultSort = 'effective_date';

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
                'key' => 'template',
                'label' => trans('payroll.salary_template.salary_template'),
                'print_label' => 'template.name',
                'sortable' => false,
                'visibility' => true,
            ],
            [
                'key' => 'effectiveDate',
                'label' => trans('payroll.salary_structure.props.effective_date'),
                'print_label' => 'effective_date_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'netEarning',
                'label' => trans('payroll.salary_structure.props.net_earning'),
                'print_label' => 'net_earning_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'netDeduction',
                'label' => trans('payroll.salary_structure.props.net_deduction'),
                'print_label' => 'net_deduction_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'netSalary',
                'label' => trans('payroll.salary_structure.props.net_salary'),
                'print_label' => 'net_salary_display',
                'sortable' => true,
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

        return SalaryStructure::query()
            ->with(['template', 'employee' => fn ($q) => $q->withSummaryRecord()])
            ->whereHas('employee', function ($q) use ($accessibleEmployeeIds, $employees) {
                $q->whereIn('id', $accessibleEmployeeIds)->when($employees, function ($q) use ($employees) {
                    $q->whereIn('uuid', $employees);
                });
            })
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\DateBetween:start_date,end_date,effective_date',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return SalaryStructureResource::collection($this->filter($request)
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
