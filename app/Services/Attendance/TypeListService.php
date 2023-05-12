<?php

namespace App\Services\Attendance;

use App\Contracts\ListGenerator;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TypeListService extends ListGenerator
{
    protected $allowedSorts = ['created_at', 'name', 'alias', 'code', 'category'];

    protected $defaultSort = 'name';

    protected $defaultOrder = 'asc';

    public function getHeaders(): array
    {
        $headers = [
            [
                'key' => 'name',
                'label' => trans('attendance.type.props.name'),
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'code',
                'label' => trans('attendance.type.props.code'),
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'category',
                'label' => trans('attendance.type.props.category'),
                'print_label' => 'category_display',
                'sortable' => true,
                'visibility' => true,
            ],
            [
                'key' => 'alias',
                'label' => trans('attendance.type.props.alias'),
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
        return AttendanceType::query()
            ->byTeam()
            ->filter([
                'App\QueryFilters\UuidMatch',
                'App\QueryFilters\LikeMatch:name',
                'App\QueryFilters\LikeMatch:code',
                'App\QueryFilters\LikeMatch:alias',
                'App\QueryFilters\ExactMatch:category',
            ]);
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        return AttendanceTypeResource::collection($this->filter($request)
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
