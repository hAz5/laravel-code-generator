{!! '<?php' !!}

namespace Tests\Feature;

use App\Constants\PermissionTitle;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Str;
use Tests\TestCase;

class {{ $studlyModelName }}Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        @if(collect($columns)->where('isTranslate')->count() > 0)
            {{ $studlyModelName }}::factory(rand(10, 20))->has({{$studlyModelName}}Translation::factory(), 'translations')->create();
        @else
            {{ $studlyModelName }}::factory(rand(10, 20))->create();
        @endif
    }
    /**
     * get {{ $pluralStudlyModelName }} list
     *
     * @return TestResponse
     */

    private function getAll{{$pluralStudlyModelName}}(): TestResponse
    {
        return $this->getJson(route('{{$modelRouteName}}.index'));
    }

    /**
     * create {{ $camelModelName }} and send request to get {{$camelModelName}}
     *
     * @param int ${{ $camelModelName }}Id
     *
     * @return TestResponse
     */
    private function get{{$studlyModelName}}(int ${{$camelModelName}}Id = 0): TestResponse
    {
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();

        return $this->getJson(
            route('{{$modelRouteName}}.show',
                [
                    '{{$snakeModelName}}' => ${{$camelModelName}}Id === 0 ? ${{$camelModelName}}->getId() : ${{$camelModelName}}Id
                ])

        );
    }

    /**
     * create random  {{$camelModelName}} and randomly delete one.
     *
     * @return array
     */
    private function delete{{$studlyModelName}}(): array
    {
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();

        return [
            'response' => $this->deleteJson(route('{{$modelRouteName}}.destroy', ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()])),
            'resource' => ${{$camelModelName}},
        ];
    }

    /**
    * @param mixed $value
    * @param string $defaultValue
    *
    * @return mixed
    */
    private function getDefaultValue(mixed $value, string $defaultValue): mixed
    {
        $default = is_numeric($value) ? 0 : $defaultValue;
        $default = is_bool($value) ? !$value: $default;

        return $value instanceof Carbon ? $value->addDays(2) : $default;
    }

   /**
    *
    * @param string $filter Filter.
    * @param mixed $value Filter Value.
    * @param String $defaultValue Default Value.
    * @param boolean $isUnique Unique Field.
    *
    * @return array|TestResponse
    */
    private function filter{{$studlyModelName}}Table(
    string $filter,
    mixed $value,
    string $defaultValue = 'null',
    bool $isUnique = false
): array|TestResponse
{
    $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_{{$pluralStudlyUpperModelName}});

        if (!is_array($value)) {
            $default = $this->getDefaultValue($value, $defaultValue);
            $updatedRecordsCount = $isUnique ? 1 : rand(2, 5);
            $updatedRecordsIds = {{$studlyModelName}}::inRandomOrder()->take($updatedRecordsCount)->get()->pluck({{$studlyModelName}}::ID)->toArray();
    {{$studlyModelName}}::whereIn({{$studlyModelName}}::ID, $updatedRecordsIds)->update([$filter => $value instanceof Carbon ? $value->toDateTimeString() : $value]);
    {{$studlyModelName}}::whereNotIn({{$studlyModelName}}::ID, $updatedRecordsIds)->where($filter, $value)
                ->update([$filter => $default instanceof Carbon ? $default->toDateTimeString() : $default]);
            return [
                'response' => $this->getJson(route('{{$modelRouteName}}.index',
                    [Str::camel($filter) => $value instanceof Carbon ? $value->toDateTimeString() : $value, 'per_page' => 20])),
                'updatedRecordsCount' => $updatedRecordsCount
            ];
        }

        return $this->getJson(route('{{$modelRouteName}}.index', [Str::camel($filter) => $value, 'per_page' => 20]));
    }

    /**
    * validate filter response
    *
    * @param string $filter Filter Name.
    * @param array $responseArray array response.
    *
    * @return void
    */
    protected function responseValidator(string $filter, array $responseArray): void
    {
        $response = $responseArray['response'];
        $updatedRecords = $responseArray['updatedRecordsCount'];
        $response->assertOk();
        $response = $response->getOriginalContent();
        $this->assertTrue($response->count() === $updatedRecords);
        $this->assertTrue(count(array_unique($response->pluck($filter)->toArray())) === 1);
    }

    /**
    * @param array $stash Valid Values.
    *
    * @return array
    * @throws \Exception.
    */
    protected function choseRandomEnum(array $stash): array
    {
        if (count($stash) == 0){
            throw new \Exception('$stash can not be empty.');
        }
        $index = rand(0, count($stash) - 1);
        return [
            'value' => $stash[$index],
            'defaultValue' => $index === 0 ? $stash[$index + 1] : $stash[$index - 1]
        ];
    }

    /**
     * @test
     */
    public function guestCanNotGetAll{{$pluralStudlyModelName}}()
    {
        $this->getAll{{$pluralStudlyModelName}}()->assertUnauthorized();
    }

    /**
    * @test
    */
    public function guestCanNotStore{{$studlyModelName}}()
    {
        $this->postJson(route('{{$modelRouteName}}.store'), [])->assertUnauthorized();
    }


    /**
    * @test
    */
    public function guestCanNotGet{{$studlyModelName}}()
    {
        $this->get{{$studlyModelName}}()->assertUnauthorized();
    }

    /**
    * @test
    */
    public function guestCanNotUpdate{{$studlyModelName}}()
    {
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();
        $this->putJson(
            route('{{$modelRouteName}}.update',
                ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()]),
                []
        )->assertUnauthorized();
    }

    /**
    * @test
    */
    public function guestCanNotDelete{{$studlyModelName}}()
    {
        $this->delete{{$studlyModelName}}()['response']->assertUnauthorized();
    }

    /**
    * @test
    */
    public function userWithoutPermissionCanNotGetAll{{$pluralStudlyModelName}}()
    {
        $this->actingAsUser();
        $this->getAll{{$pluralStudlyModelName}}()->assertForbidden();
    }

    /**
    * @test
    */
    public function userWithoutPermissionCanNotGet{{$studlyModelName}}()
    {
        $this->actingAsUser();
        $this->get{{$studlyModelName}}()->assertForbidden();
    }

    /**
    * @test
    */
    public function userWithoutPermissionCanNotStore{{$studlyModelName}}()
    {
        $this->actingAsUser();
        $this->postJson(route('{{$modelRouteName}}.store'), [])->assertForbidden();
    }

    /**
    * @test
    */
    public function userWithoutPermissionCanNotUpdate{{$studlyModelName}}()
    {
        $this->actingAsUser();
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();
        $this->putJson(
        route('{{$modelRouteName}}.update', ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()]),
            []
        )->assertForbidden();
    }

    /**
    * @test
    */
    public function userWithoutPermissionCanNotDelete{{$studlyModelName}}()
    {
        $this->actingAsUser();
        $responseArray = $this->delete{{$studlyModelName}}();
        $responseArray['response']->assertForbidden();
    }

    /**
    * @test
    */
    public function userWithPermissionCanGetAll{{$pluralStudlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_{{$pluralStudlyUpperModelName}});
        $this->getAll{{$pluralStudlyModelName}}()->assertOk();
    }

    /**
    * @test
    */
    public function userWithPermissionCanGet{{$studlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_{{$studlyUpperModelName}});
        $this->get{{$studlyModelName}}()->assertOk();
    }

    /**
    * @test
    */
    public function userWithPermissionCanStore{{$studlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{$studlyUpperModelName}});
        $fake = {{$studlyModelName}}::factory()->make();
    @if(collect($columns)->where('isTranslate', true)->count() > 0)
        $fakeTranslate = {{$studlyModelName}}Translation::factory()->make();
    @endif

    $response = $this->postJson(
    route('{{$modelRouteName}}.store'),
    [
        @foreach($columns as $column)
            @if($column['isTranslate']) @continue @endif
            {{$studlyModelName}}::{{$column['const']}} => $fake->get{{$column['studly']}}(),
        @endforeach
        @if(collect($columns)->where('isTranslate', true)->count() > 0)
            LocalizableModel::LOCALIZATION_KEY => [
                    $fakeTranslate->toArray()
            ]
        @endif
    ]
    );

    $response->assertCreated();
    ${{$camelModelName}} = $response->getOriginalContent();
    $this->assertTrue(${{$camelModelName}} instanceof {{$studlyModelName}}Interface);
@foreach($columns as $column)
@if($column['isTranslate']) @continue @endif
$this->assertEquals(${{$camelModelName}}->get{{$column['studly']}}(), $fake->get{{$column['studly']}}());
@endforeach
@if(collect($columns)->where('isTranslate', true)->count() > 0)
    @foreach($columns as $column)
        @if(!$column['isTranslate']) @continue @endif
        $this->assertEquals(${{$camelModelName}}->translations->first()->get{{$column['studly']}}(), $fakeTranslate->get{{$column['studly']}}());
    @endforeach
@endif

    }


    /**
    * @test
    */
    public function userWithPermissionCanUpdate{{$studlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{$studlyUpperModelName}});
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();
        $fake = {{$studlyModelName}}::factory()->make();
        @if(collect($columns)->where('isTranslate', true)->count() > 0)
            $fakeTranslate = {{$studlyModelName}}Translation::factory()->make();
        @endif

    $response = $this->putJson(
    route('{{$modelRouteName}}.update', ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()]),
    [
@foreach($columns as $column)
    @if($column['isTranslate']) @continue @endif
    {{$studlyModelName}}::{{$column['const']}} => $fake->get{{$column['studly']}}(),
@endforeach
@if(collect($columns)->where('isTranslate', true)->count() > 0)
    LocalizableModel::LOCALIZATION_KEY => [
    $fakeTranslate->toArray()
    ]
@endif
    ]
    );

    $response->assertOk();
    ${{$camelModelName}} = $response->getOriginalContent();
    $this->assertTrue(${{$camelModelName}} instanceof {{$studlyModelName}}Interface);
@foreach($columns as $column)
    @if($column['isTranslate']) @continue @endif
    $this->assertEquals(${{$camelModelName}}->get{{$column['studly']}}(), $fake->get{{$column['studly']}}());
@endforeach
@if(collect($columns)->where('isTranslate', true)->count() > 0)
    @foreach($columns as $column)
        @if(!$column['isTranslate']) @continue @endif
        $this->assertEquals(${{$camelModelName}}->translations->first()->get{{$column['studly']}}(), $fakeTranslate->get{{$column['studly']}}());
    @endforeach
@endif

    }

    /**
    * @test
    */
    public function userWithPermissionCanDelete{{$studlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::DELETE_{{$studlyUpperModelName}});
        $responseArray = $this->delete{{$studlyModelName}}();
        $responseArray['response']->assertNoContent();
        $this->get{{$studlyModelName}}($responseArray['{{$camelModelName}}']->getId())->assertNotFound();
    }

    /**
    * @test
    */
    public function userCanNotStore{{$studlyModelName}}WithoutRequiredFields()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{$studlyUpperModelName}});
        $response = $this->postJson(
        route('{{$modelRouteName}}.store'),
            []
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();

@foreach($columns as $column)
@if(!$column['nullable'] || $column['isTranslate']) @continue @endif
$this->assertArrayHasKey({{$studlyModelName}}::{{$column['const']}}, $content);
@endforeach
    }

    /**
    * @test
    */
    public function userCanNotUpdate{{$studlyModelName}}WithoutRequiredFields()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{$studlyUpperModelName}});
        ${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();

        $response = $this->putJson(
        route('{{$modelRouteName}}.update', ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()]),
            []
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();
@foreach($columns as $column)
    @if(!$column['nullable']) @continue @endif
    $this->assertArrayHasKey({{$studlyModelName}}::{{$column['const']}}, $content);
@endforeach
    }

    /**
    * @test
    */
    public function userCanNotStore{{$studlyModelName}}WithInvalidFields()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{$studlyUpperModelName}});
        $response = $this->postJson(
        route('{{$modelRouteName}}.store'),
            [
@foreach($columns as $column)
    {{$studlyModelName}}::{{$column['const']}} => {!! $column['badValue'] !!},
@endforeach
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();

@foreach($columns as $column)
$this->assertArrayHasKey({{$studlyModelName}}::{{$column['const']}}, $content);
@endforeach
    }

    /**
    * @test
    */
    public function userCanNotUpdate{{$studlyModelName}}WithInvalidFields()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{$studlyUpperModelName}});
${{$camelModelName}} = {{$studlyModelName}}::inRandomOrder()->first();
$response = $this->putJson(
route('{{$modelRouteName}}.update', ['{{$snakeModelName}}' => ${{$camelModelName}}->getId()]),
[
@foreach($columns as $column)
@if($column['isTranslate']) @continue @endif
    {{$studlyModelName}}::{{$column['const']}} => {!! $column['badValue'] !!},
@endforeach
]
);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();

@foreach($columns as $column)
@if($column['isTranslate']) @continue @endif
    $this->assertArrayHasKey({{$studlyModelName}}::{{$column['const']}}, $content);
@endforeach

}

    /**
    * @test
    */
    public function UserCanNotDelete{{ $studlyModelName }}WithWrongId()
    {
        $this->actingAsUserWithPermission(PermissionTitle::DELETE_{{ $studlyUpperModelName }});
        $this->deleteJson(
            route('{{ $modelRouteName }}.destroy', 0),
        )->assertNotFound();
    }

    /**
    * @test
    */
    public function filter{{$pluralStudlyModelName}}ByIds()
    {
        $ids = [1, 2, 5, 6];
        $response = $this->filterProductDimensionTable({{$studlyModelName}}::ID . 's', $ids);
        $response->assertOk();
        $this->assertTrue($response->getOriginalContent()->count() === count($ids));
        $responseIds = $response->getOriginalContent()->pluck({{$studlyModelName}}::ID)->toArray();
        $this->assertTrue(asort($responseIds) === asort($ids));
    }
@foreach($columns as $column)
@if($column['isTranslate']) @continue @endif
        /**
        * @test
        */
        public function filter{{$pluralStudlyModelName}}By{{$column['studly']}}()
        {
            @if($column['enum'] == true)
                $data = $this->choseRandomEnum({{$studlyModelName}}::${{$column['camel']}}s);
                $responseArray = $this->filter{{$studlyModelName}}Table({{$studlyModelName}}::{{$column['const']}}, $data['value'], $data['defaultValue']);
            @else
                $value = {{$studlyModelName}}::factory()->make()->get{{$column['studly']}}();
                $responseArray = $this->filter{{$studlyModelName}}Table({{$studlyModelName}}::{{$column['const']}}, $value);
            @endif
            $this->responseValidator({{$studlyModelName}}::{{$column['const']}}, $responseArray);
        }
@endforeach
}
