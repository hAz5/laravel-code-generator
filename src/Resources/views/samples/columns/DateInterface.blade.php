{!! '<?php' !!}

namespace App\Interfaces\Traits;

use Illuminate\Database\Eloquent\Builder;

interface Has{{$col['studly']}}Interface
{
    /**
     * @param Builder $builder   Builder.
     * @param string  $date      Date.
     *
     * @return Builder
     */
    public function scopeWhere{{$col['studly']}}GreaterThan(Builder $builder, string $date): Builder;

    /**
     * @param Builder $builder   Builder.
     * @param string  $date      Date.
     *
     * @return Builder
     */
    public function scopeWhere{{$col['studly']}}LessThan(Builder $builder, string $date): Builder;
}
