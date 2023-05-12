<?php

namespace App\Services\Payroll;

use App\Contracts\ListGenerator;
use App\Http\Resources\Payroll\PayHeadResource;
use App\Models\Payroll\PayHead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PayHeadListService extends ListGenerator
{
    protected $allowedSorts = ['created_at', 'name', 'code', 'alias', 'type'];

    protected $defaultSort = 'name';

    protected $defaultOrder = 'asc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'name',
                'label' => trans('payroll.pay_head.props.name'),
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'code',
                'label' => trans('payroll.pay_head.props.code'),
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'alias',
                'label' => trans('payroll.pay_head.props.alias'),
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'type',
                'label' => trans('payroll.pay_head.props.type'),
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
        return PayHead::query()
            ->byTeam()
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\LikeMatch:name',
                'App\QueryFilters\LikeMatch:code',
                'App\QueryFilters\LikeMatch:alias',
                'App\QueryFilters\LikeMatch:type',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return PayHeadResource::collection($this->filter($request)
                ->orderBy($this->getSort(), $this->getOrder())
                ->paginate((int) $this->getPageLength(), ['*'], 'current_page'))
        ->additional([
            'headers' => $this->getHeaders(),
            'meta' => [
                'allowed_sorts' => $this->allowedSorts,
                'default_sort' => $this->defaultSort,
                'default_order' => $this->defaultOrder,
                'title' => 'PayHead',
            ],
        ]);
    }

    public function list(Request $request): AnonymousResourceCollection
    {
        return $this->paginate($request);
    }
}
