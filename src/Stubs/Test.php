<?php

namespace Tests\Feature;

class {{studlyModelName}}Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageSeeder::class);
    }

    /**
     * get {{pluralStudlyModelName}} list
     *
     * @return TestResponse
     */
    private function getAll{{pluralStudlyModelName}}(): TestResponse
    {
        {{studlyModelName}}::factory(rand(10, 20))->has({{studlyModelName}}Translation::factory(), 'translations')->create();
        return $this->getJson(route('{{modelRouteName}}.index'));
    }

    /**
     * create {{camelModelName}} and send request to get {{camelModelName}}
     *
     * @param int ${{camelModelName}}Id
     *
     * @return TestResponse
     */
    private function get{{studlyModelName}}(int ${{camelModelName}}Id = 0): TestResponse
    {
        {{studlyModelName}}::factory(3)->has({{studlyModelName}}::factory(), 'translations')->create();
        ${{camelModelName}} = {{studlyModelName}}::inRandomOrder()->first();

        return $this->getJson(
            route('{{modelRouteName}}.show',
                [
                    '{{snakeModelName}}' => ${{camelModelName}}Id === 0 ? ${{camelModelName}}->getId() : ${{camelModelName}}Id
                ])

        );
    }

    /**
     * create random  {{camelModelName}} and randomly delete one.
     *
     * @return array
     */
    private function delete{{studlyModelName}}(): array
    {
        {{studlyModelName}}::factory(rand(3, 6))->has({{studlyModelName}}::factory(), 'translations')->create();
        ${{camelModelName}} = {{studlyModelName}}::inRandomOrder()->first();

        return [
            'response' => $this->deleteJson(route('{{modelRouteName}}.destroy', ['{{snakeModelName}}' => ${{camelModelName}}->getId()])),
            'resource' => ${{camelModelName}},
        ];
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
    private function filter{{studlyModelName}}Table(
        string $filter,
        array|string|int|float $value,
        string $defaultValue = 'null',
        bool $isUnique = false
    ): array|TestResponse
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_{{snackUpperModelName}}S);
        {{studlyModelName}}::factory(rand(10, 50))->has({{studlyModelName}}Translation::factory(), 'translations')->create();

        if (!is_array($value)) {
            $default = is_numeric($value) ? 0 : $defaultValue;
            $updatedRecordsCount = $isUnique ? 1 : rand(2, 5);
            $updatedRecordsIds = {{studlyModelName}}::inRandomOrder()->take($updatedRecordsCount)->get()->pluck({{studlyModelName}}::ID)->toArray();
            {{studlyModelName}}::whereIn({{studlyModelName}}::ID, $updatedRecordsIds)->update([$filter => $value]);
            {{studlyModelName}}::whereNotIn({{studlyModelName}}::ID, $updatedRecordsIds)->where($filter, $value)->update([$filter => $default]);
            return [
                'response' => $this->getJson(route('{{modelRouteName}}.index', [Str::camel($filter) => $value, 'per_page' => 20])),
                'updatedRecordsCount' => $updatedRecordsCount
            ];
        }

        return $this->getJson(route('{{modelRouteName}}.index', [Str::camel($filter) => $value, 'per_page' => 20]));
    }

    /**
     * @test
     */
    public function userWithoutLoginCanNotGetAll{{pluralStudlyModelName}}()
    {
        $this->getAll{{pluralStudlyModelName}}()->assertUnauthorized();
    }

    /**
     * @test
     */
    public function userWithoutPermissionCanNotGetAll{{pluralStudlyModelName}}()
    {
        $this->actingAsUser();
        $this->getAll{{pluralStudlyModelName}}()->assertForbidden();
    }

    /**
     * @test
     */
    public function userWithPermissionCanGetAll{{pluralStudlyModelName}}()
    {
        $this->actingAsUserWithPermission(PermissionTitle::GET_ALL_SUBDOMAINS);
        $this->getAll{{pluralStudlyModelName}}()->assertOk();
    }

    /**
     * @test
     */
    public function userWithoutLoginCanNotStore{{studlyModelName}}()
    {
        $this->postJson(route('{{modelRouteName}}.store'), [])->assertUnauthorized();
    }

    /**
     * @test
     */
    public function userWithoutPermissionCanNotStore{{studlyModelName}}()
    {
        $this->actingAsUser();
        $this->postJson(route('{{modelRouteName}}.store'), [])->assertForbidden();
    }

}
