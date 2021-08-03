{!! '<?php' !!}

namespace App\Interfaces\Models;

use Illuminate\Database\Eloquent\Builder;

interface {{ model }}Interface
{
    const TABLE = '{{ modelTableName }}';
    @foreach($columns as $key => $col)
        const COL_{{ $col['upper'] }} = '{{ $key }}';
    @endforeach
}
