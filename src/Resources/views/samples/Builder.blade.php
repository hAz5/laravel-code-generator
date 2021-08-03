{!! '<?php' !!}

namespace KfwBundle\{{ $bundle }}\Builders;

use Illuminate\Database\Eloquent\Builder;
use KfwBundle\{{ $bundle }}\Models\{{ $studlyModelName }};

class {{ $studlyModelName }}Builder extends Builder
{
@foreach($columns as $col)
    /**
     * filter {{ $studlyModelName }} by {{ $col['camel'] }}.
     *
     * @param int ${{ $col['camel'] }} ID.
     *
     * @return {{ $studlyModelName }}Builder
     */
    public function filterBy{{ $col['studly'] }}(int ${{ $col['camel'] }}): {{ $studlyModelName }}Builder
    {
        return $this->where({{ $studlyModelName }}::COL_{{ $col['const'] }}, ${{ $col['camel'] }});
    }
@endforeach
}
