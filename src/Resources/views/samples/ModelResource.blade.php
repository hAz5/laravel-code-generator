{!! '<?php' !!}

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class {{ Str::studly($model) }}Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN)
        @continue
    @endif
{{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper() }} => $this->get{{Str::studly($column['fieldName'])}}(),
@endforeach
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN)
                    '{{ Str::of($column['fieldName'])->beforeLast('_id')->camel() }}' => $this->whenLoaded(
                        '{{ Str::of($column['fieldName'])->beforeLast('_id')->camel() }}',
                        function () {
                            return new {{ Str::of($column['fieldName'])->beforeLast('_id')->studly() }}Resource($this->{{ Str::of($column['fieldName'])->beforeLast('_id')->camel() }});
                        }
                    ),
    @endif
@endforeach
        ];
    }
}
