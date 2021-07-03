{!! '<?php' !!}

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Has{{$col['studly']}}Trait
{
    /**
     * @param Builder $builder   Builder.
     * @param string  $date      Date.
     *
     * @return Builder
     */
    public function scopeWhere{{$col['studly']}}GreaterThan(Builder $builder, string $date): Builder
    {
        return $builder->where(self::{{ $col['const'] }}, '>=', $date);
    }

    /**
     * @param Builder $builder   Builder.
     * @param string  $date      Date.
     *
     * @return Builder
     */
    public function scopeWhere{{$col['studly']}}LessThan(Builder $builder, string $date): Builder
    {
        return $builder->where(self::{{ $col['const'] }}, '<=', $date);
    }
}
