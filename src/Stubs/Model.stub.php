<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\{{ model }};
use App\Interfaces\Models\{{ modelInterface }};

class {{ model }} extends BaseModel implements {{ modelInterface }}
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        {{ columns }}
    ];

    /**
     * Filter scope.
     *
     * @param Builder            $builder Builder.
     * @param {{ modelFilter }} $filters Filters.
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, {{ modelFilter }} $filters): Builder
    {
        return $filters->apply($builder);
    }


    /**
     * Create new ContactGroup.
     *
     * @param array $data Data.
     *
     * @return {{ modelInterface }}
     */
    public static function createObject(array $data): {{ modelInterface }}
    {

        return self::create($data);
    }

    /**
     * update existing ContactGroup.
     *
     * @param array $data Data.
     *
     * @return {{ modelInterface }}
     */
    public function updateObject(array $data): {{ modelInterface }}
    {
        $this->update($data);

        return $this;
    }
}
