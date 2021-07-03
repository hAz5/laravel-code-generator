{!! '<?php' !!}

namespace Tests\Feature;

use App\Constants\PermissionTitle;
use App\Models\LocalizableModel;
use {{ $studlyModelName }};
use {{ $studlyModelName }}Translation;
use App\Models\User\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class {{ $studlyModelName }}Test extends TestCase
{

    /**
     * @test
     */
    public function testGuestCantCreate{{ $studlyModelName }}()
    {
        $this->postJson(
            route('{{ $modelRouteName }}.store'),
        )->assertUnauthorized();
    }

    /**
     * @test
     */
    public function testGuestCantUpdate{{ $studlyModelName }}()
    {
        $item = {{ $studlyModelName }}::factory()->create();
        $this->putJson(
            route('{{ $modelRouteName }}.update', $item->getId()),
        )->assertUnauthorized();
    }

    /**
     * @test
     */
    public function testGuestCantSee{{ $studlyModelName }}()
    {
        $item = {{ $studlyModelName }}::factory()->create();
        $this->getJson(
            route('{{ $modelRouteName }}.show', $item->getId()),
        )->assertUnauthorized();
    }

    /**
     * @test
     */
    public function testGuestCantDelete{{ $studlyModelName }}()
    {
        $item = {{ $studlyModelName }}::factory()->create();
        $this->deleteJson(
            route('{{ $modelRouteName }}.destroy', $item->getId()),
        )->assertUnauthorized();
    }

    /**
     * @test
     */
    public function testGuestCantSee{{ $studlyModelName }}List()
    {
        $response = $this->getJson(
            route('{{ $modelRouteName }}.index'),
        );
        $response->assertUnauthorized();
    }
    /**
     * @test
     */
    public function testUserCantCreate{{ $studlyModelName }}WithoutPermission()
    {
        $this->actingAsUser();
        $this->postJson(
            route('{{ $modelRouteName }}.store'),
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function testUserCantUpdate{{ $studlyModelName }}WithoutPermission()
    {
        $this->actingAsUser();
        $item = {{ $studlyModelName }}::factory()->create();
        $this->putJson(
            route('{{ $modelRouteName }}.update', $item->getId()),
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function testUserCantDelete{{ $studlyModelName }}WithoutPermission()
    {
        $this->actingAsUser();
        $item = {{ $studlyModelName }}::factory()->create();
        $this->deleteJson(
            route('{{ $modelRouteName }}.destroy', $item->getId()),
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function testUserCantSee{{ $studlyModelName }}WithoutPermission()
    {
        $this->actingAsUser();
        $item = {{ $studlyModelName }}::factory()->create();
        $this->getJson(
            route('{{ $modelRouteName }}.show', $item->getId()),
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function testUserCantSee{{ $studlyModelName }}ListWithoutPermission()
    {
        $this->actingAsUser();
        $this->getJson(
            route('{{ $modelRouteName }}.index'),
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function testUserCanSee{{ $studlyModelName }}List()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_{{ $pluralStudlyUpperModelName }});
        $response = $this->getJson(
            route('{{ $modelRouteName }}.index'),
        );
        $response->assertOk();
    }

    /**
     * @test
     */
    public function testUserCanDelete{{ $studlyModelName }}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::DELETE_{{ $studlyUpperModelName }});
        $item = {{ $studlyModelName }}::factory()->create();

        $this->deleteJson(
            route('{{ $modelRouteName }}.destroy', $item),
        )->assertNoContent();

        $deleted{{ $studlyModelName }} = {{ $studlyModelName }}::whereId($item->getId())->first();
        $this->assertNull($deleted{{ $studlyModelName }});
    }

    /**
     * @test
     */
    public function testUserCantDelete{{ $studlyModelName }}WithWrongId()
    {
        $this->actingAsUserWithPermission(PermissionTitle::DELETE_{{ $studlyUpperModelName }});
        $this->deleteJson(
            route('{{ $modelRouteName }}.destroy', 15),
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function testUserCantSee{{ $studlyModelName }}WithWrongId()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_{{ $studlyUpperModelName }});
        $this->getJson(
            route('{{ $modelRouteName }}.show', 15),
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function testUserCanSee{{ $studlyModelName }}WithId()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_{{ $studlyUpperModelName }});
        $item = {{ $studlyModelName }}::factory()
            ->has({{ $studlyModelName }}Translation::factory(), 'translations')
            ->create();

        $response = $this->getJson(
            route('{{ $modelRouteName }}.show', $item->getId()),
        );
        $response->assertOk();
        $this->assertEquals(
            $response->getOriginalContent()->translations->first()->getName(),
            $item->translations->first()->getName()
        );
@foreach($columns as $col)
        $this->assertEquals($response->getOriginalContent()->get{{ $col['studly'] }}(), $item->get{{ $col['studly'] }}());
@endforeach
    }

    /**
     * @test
     */
    public function testUserCanCreate{{ $studlyUpperModelName }}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{ $studlyUpperModelName }});
        $fakeItem = {{ $studlyModelName }}::factory()->make();
        $translations = {{ $studlyModelName }}Translation::factory()->make();

        $response = $this->postJson(
            route('{{ $modelRouteName }}.store'),
            [
@foreach($columns as $col)
                {{ $studlyModelName }}::{{ $col['const'] }} => $fakeItem->get{{ $col['studly'] }}(),
@endforeach
                LocalizableModel::LOCALIZATION_KEY => [
                    [
                        {{ $studlyModelName }}Translation::LOCALE => $translations->getLocale(),
                        {{ $studlyModelName }}Translation::NAME => $translations->getName(),
                    ]
                ]
            ]
        );
        $response->assertCreated();
        $this->assertEquals(
            $response->getOriginalContent()->translations->first()->getName(),
            $translations->getName()
        );
@foreach($columns as $col)
        $this->assertEquals($fakeItem->get{{ $col['studly'] }}(), $response->getOriginalContent()->get{{ $col['studly'] }}());
@endforeach
    }

    /**
     * @test
     */
    public function testUserCantCreate{{ $studlyModelName }}CheckRequiredFieldParameter()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{ $studlyUpperModelName }});
        $response = $this->postJson(
            route('{{ $modelRouteName }}.store'),
            []
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();
        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY, $content);
@foreach($columns as $col)
$this->assertArrayHasKey({{ $studlyModelName }}::{{ $col['const'] }}, $content);
@endforeach
    }

    /**
     * @test
     */
    public function testUserCantCreate{{ $studlyModelName }}CheckInvalidFieldParameter()
    {
        $this->actingAsUserWithPermission(PermissionTitle::CREATE_{{ $studlyUpperModelName }});
        $response = $this->postJson(
            route('{{ $modelRouteName }}.store'),
            [
@foreach($columns as $col)
                {{ $studlyModelName }}::{{ $col['const'] }} => '{{ $col['badValue'] }}',
@endforeach
                LocalizableModel::LOCALIZATION_KEY => [
                    'xx' => [
                        {{ $studlyModelName }}Translation::LOCALE => 'xx',
                        {{ $studlyModelName }}Translation::NAME => true,
                    ]
                ]
            ]
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();

        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY . '.xx.' . {{ $studlyModelName }}Translation::NAME, $content);
        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY . '.xx.' . {{ $studlyModelName }}Translation::LOCALE, $content);
@foreach($columns as $col)
        $this->assertArrayHasKey({{ $studlyModelName }}::{{ $col['const'] }}, $content);
@endforeach
    }

    /**
     * @test
     */
    public function testUserCanUpdate{{ $studlyModelName }}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{ $studlyUpperModelName }});
        $item = {{ $studlyModelName }}::factory()
            ->has({{ $studlyModelName }}Translation::factory(), 'translations')
            ->create();
        $update = {{ $studlyModelName }}::factory()->make();
        $updateTranslation = {{ $studlyModelName }}Translation::factory()->make();

        $response = $this->putJson(
            route('{{ $modelRouteName }}.update', $item->getId()),
            [
@foreach($columns as $col)
    {{ $studlyModelName }}::{{ $col['const'] }} => $update->get{{ $col['studly'] }}(),
@endforeach
                LocalizableModel::LOCALIZATION_KEY => [
                    [
                        {{ $studlyModelName }}Translation::LOCALE => $updateTranslation->getLocale(),
                        {{ $studlyModelName }}Translation::NAME => $updateTranslation->getName(),
                    ]
                ]
            ]
        );

        $response->getOriginalContent()->load('translations');
        $response->assertOk();
        $this->assertEquals(
            $response->getOriginalContent()->translations->first()->getName(),
            $updateTranslation->getName()
        );
@foreach($columns as $col)
    $this->assertEquals($update->get{{ $col['studly'] }}(), $response->getOriginalContent()->get{{ $col['studly'] }}());
@endforeach
    }

    /**
     * @test
     */
    public function testUserCantUpdate{{ $studlyModelName }}CheckRequiredFieldParameter()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{ $studlyUpperModelName }});
        $item = {{ $studlyModelName }}::factory()->create();

        $response = $this->putJson(
            route('{{ $modelRouteName }}.update', $item->getId()),
            []
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();
        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY, $content);
@foreach($columns as $col)
    $this->assertArrayHasKey({{ $studlyModelName }}::{{ $col['studly'] }}, $content);
@endforeach
    }

    /**
     * @test
     */
    public function testUserCantUpdate{{ $studlyModelName }}CheckInvalidFieldParameter()
    {
        $this->actingAsUserWithPermission(PermissionTitle::UPDATE_{{ $studlyUpperModelName }});
        User::factory()->create();
        $item = {{ $studlyModelName }}::factory()->create();

        $response = $this->putJson(
            route('{{ $modelRouteName }}.update', $item->getId()),
            [
@foreach($columns as $col)
    {{ $studlyModelName }}::{{ $col['studly'] }} => '{{ $col['badValue'] }}',
@endforeach
                LocalizableModel::LOCALIZATION_KEY => [
                    'xx' => [
                        {{ $studlyModelName }}Translation::LOCALE => 'xx',
                        {{ $studlyModelName }}Translation::NAME => true,
                    ]
                ]
            ]
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        /** @var array $content */
        $content = $response->getOriginalContent()->toArray();

        $this->assertArrayHasKey({{ $studlyModelName }}::AVERAGE_DAYS, $content);
        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY . '.xx.' . {{ $studlyModelName }}Translation::NAME, $content);
        $this->assertArrayHasKey(LocalizableModel::LOCALIZATION_KEY . '.xx.' . {{ $studlyModelName }}Translation::LOCALE, $content);
@foreach($columns as $col)
    $this->assertArrayHasKey({{ $studlyModelName }}::{{ $col['studly'] }}, $content);
@endforeach
    }

    /**
    *
    * @param string $filter Filter.
    * @param array|string|float|integer $value Filter Value.
    * @param String $defaultValue Default Value.
    * @param boolean $isUnique Unique Field.
    *
    * @return array|TestResponse
    */
    private function filter{{ $studlyModelName }}Table(
    string $filter,
    array|string|int|float $value,
    string $defaultValue = 'null',
    bool $isUnique = false
    ): array|TestResponse
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_ADDRESSES);
        Address::factory(rand(10, 20))->create();

        if (!is_array($value)) {
            $default = is_numeric($value) ? 0 : $defaultValue;
            $updatedRecordsCount = $isUnique ? 1 : rand(2, 5);
            // update random record in {{ $studlyModelName }} table
            $updatedRecordsIds = {{ $studlyModelName }}::inRandomOrder()->take($updatedRecordsCount)->get()->pluck({{ $studlyModelName }}::ID)->toArray();
{{ $studlyModelName }}::whereIn({{ $studlyModelName }}::ID, $updatedRecordsIds)->update([$filter => $value]);
{{ $studlyModelName }}::whereNotIn({{ $studlyModelName }}::ID, $updatedRecordsIds)->where($filter, $value)->update([$filter => $default]);
            return [
                'response' => $this->getJson(route('{{ $studlyModelName }}.index', [Str::camel($filter) => $value, 'per_page' => 20])),
                'updatedRecordsCount' => $updatedRecordsCount
            ];
        }

        return $this->getJson(route('addresses.index', [Str::camel($filter) => $value, 'per_page' => 20]));
    }

@foreach($columns as $col)
    /**
    * @test
    */
    public function filter{{ $studlyModelName }}ItemsBy{{ $col['studly'] }}()
    {
        $responseArray = $this->filterAddressTable({{ $studlyModelName }}::{{ $col['const'] }}, 1);
        $response = $responseArray['response'];
        $updatedRecords = $responseArray['updatedRecordsCount'];
        $response->assertOk();
        $this->assertTrue($response->getOriginalContent()->count() === $updatedRecords);
        $this->assertTrue(
            count(
                array_unique(
                    $response->getOriginalContent()->pluck({{ $studlyModelName }}::{{ $col['const'] }})->toArray()
                )
            ) === 1
        );
    }
@endforeach
}
