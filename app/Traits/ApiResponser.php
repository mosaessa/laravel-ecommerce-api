<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{
    private function sucessResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->cachResponse($collection);
        return $this->sucessResponse(['data' => $collection->values(), 'code' => $code], $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return $this->sucessResponse(['data' => $model, 'code' => $code], $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->sucessResponse(['data' => $message], $code);
    }

    protected function transfromData($data, $transformer)
    {
        // $transformation = fractal($data, new $transformer);

    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;
            $collection = $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    protected function filterData(Collection $collection)
    {

        foreach (request()->query() as $query => $value) {
            if ($query == 'sort_by') continue;

            $collection = $collection->where($query, $value);
        }
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 6;
        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }

    protected function cachResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();
        $queryString = http_build_query($queryParams);
        $fullUrl = "${url}?${queryString}";
        return Cache::remember($fullUrl, 30, function () use ($data) {
            return $data;
        });
    }
}
