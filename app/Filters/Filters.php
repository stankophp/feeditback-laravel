<?php


namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

abstract class Filters
{
    protected $filters = [];
    /**
     * @var Request
     */
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter) && !empty($value)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    private function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
