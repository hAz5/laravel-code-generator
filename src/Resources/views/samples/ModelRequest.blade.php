{!! '<?php' !!}

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class {{Str::studly($model)}}Request extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN)
        {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper() }} => ['required', Rule::exists(Country::TABLE, Country::ID)],
    @endif
@endforeach
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN)
        @continue
    @endif
    {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper() }} => ['required'],
@endforeach
        ];
    }
}
