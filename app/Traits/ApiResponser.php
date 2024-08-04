<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;


trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}
	protected function showAll(Collection $collection, $code = 200)

	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

		$transformer = $collection->first()->transformer;

		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->paginate($collection);
		$collection = $this->transformData($collection, $transformer);
		$collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	protected function showAllBasic(Collection $collection, $code = 200)
	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

		$transformerbasico = $collection->first()->transformerbasico;

		$collection = $this->filterData($collection, $transformerbasico);
		$collection = $this->sortData($collection, $transformerbasico);
		$collection = $this->transformData($collection, $transformerbasico);
		$collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	protected function showAllWp(Collection $collection, $code = 200)
	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

		$transformer = $collection->first()->transformer;

		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->transformData($collection, $transformer);
		$collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	protected function showfAll(Collection $collection, $code = 200)
	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

		$transformer = $collection->first()->transformerfilt;

		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->paginate($collection);
		$collection = $this->transformData($collection, $transformer);
		$collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{
		$transformer = $instance->transformer;
		$instance = $this->transformData($instance, $transformer);

		return $this->successResponse($instance, $code);
	}

	protected function showOneSec(Model $instance, $code = 200)
	{
		$transformerSec = $instance->transformerSec;
		$instance = $this->transformData($instance, $transformerSec);

		return $this->successResponse($instance, $code);
	}

	protected function showOneFilt(Model $instance, $code = 200)
	{
		$transformer = $instance->transformerfilt;
		$instance = $this->transformData($instance, $transformer);

		return $this->successResponse($instance, $code);
	}

	protected function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
	}

	protected function filterData(Collection $collection, $transformer)
	{
		foreach (request()->query() as $query => $value) {
			$attribute = $transformer::originalAttribute($query);

			if (isset($attribute, $value) &&  $query != 'search' ) {
				$collection = $collection->where($attribute,  $value );
			}
		}

		return $collection;
	}

	protected function sortData(Collection $collection, $transformer)
	{
		if (request()->has('sort_by')) {
			$attribute = $transformer::originalAttribute(request()->sort_by);
			$collection = $collection->sortBy->{$attribute};
		}
		return $collection;
	}

	protected function paginate(Collection $collection)
	{
		$rules = [
			'per_page' => 'integer|min:2|max:50'
		];

		Validator::validate(request()->all(), $rules);

		$page = LengthAwarePaginator::resolveCurrentPage();

		$perPage = 8;
		if (request()->has('per_page')) {
			$perPage = (int) request()->per_page;
		}

		$results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPath(),
		]);

		$paginated->appends(request()->all());

		return $paginated;
	}

	protected function transformData($data, $transformer)
	{
		$transformation = fractal($data, new $transformer);
		$resp = $transformation->toArray();
		return $resp;
	}

	protected function cacheResponse($data)
	{
		$url = request()->url();
		$queryParams = request()->query();

		ksort($queryParams);

		$queryString = http_build_query($queryParams);

		$fullUrl = "{$url}?{$queryString}";

		return Cache::remember($fullUrl, 30/60, function() use($data) {
			return $data;
		});
	}


    protected function updatefile(UploadedFile $file)
    {
		$dominio = "";
        $name = time() . $file->getClientOriginalName();
        $im = '/images/';
        $ruta = public_path() .$im.$name;
        if(!file_exists($ruta) ){
            $res = $file->move(public_path().$im, $name);
			if($res && $name != null && $name != ""){
				$dominio = "https://".$_SERVER['SERVER_NAME']."/public".$im.$name;
			}
        }
        return $dominio; 
    }


}