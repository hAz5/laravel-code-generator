{!! '<?php' !!}

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class {{$studlyModelName}}Request extends BaseRequest
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
        {{ $studlyModelName }}::{{$column['const'] }} => ['required', 'numeric', Rule::exists({{$column['model']}}::TABLE, {{$column['model']}}::ID)],
    @endif
@endforeach
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN || $column['isTranslate'])
        @continue
    @endif
    {{ $studlyModelName }}::{{$column['const']}} => ['required'],
@endforeach

@if(collect($columns)->where('isTranslate', true)->count() > 0)
    LocalizableModel::LOCALIZATION_KEY => ['required', 'array'],
    LocalizableModel::LOCALIZATION_KEY . '.*.locale' => [
    'required',
    'distinct',
    Rule::exists(Language::TABLE, Language::ALPHA2)
    ],
@foreach($columns as $column)
    @if(!$column['isTranslate'])
        @continue
    @endif
    LocalizableModel::LOCALIZATION_KEY . '.*.' . {{$studlyModelName}}Translation::NAME => [
        'required',
        'string',
        Rule::unique(
    {{ $studlyModelName }}Translation::TABLE,
    {{ $studlyModelName }}Translation::NAME
        )->ignore(
            optional($this->{{$snakeModelName}})->getId(),
    {{ $studlyModelName }}Translation::{{$snackUpperModelName}}_ID
        ),
    ],
@endforeach
@endif
        ];
    }
}
