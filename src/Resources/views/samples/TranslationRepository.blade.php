{!! '<?php' !!}

namespace App\Repositories;

use App\Interfaces\Models\{{ Str::studly($model) }}Interface;
use App\Models\LocalizableModel;
use App\Models\{{ Str::studly($model) }};
use App\Repositories\BaseRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class {{ Str::studly($model) }}Repository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return {{ Str::studly($model) }}::class;
    }

    /**
     * @param array $data Data.
     *
     * @return {{ Str::studly($model) }}Interface|array
     */
    public function store(array $data): array|{{ Str::studly($model) }}Interface
    {
        DB::beginTransaction();

        try {
            $item = {{ Str::studly($model) }}::createObject($data);
            /** Sync Multilingual */
            $item = $this->syncMultilingual($item, $data[LocalizableModel::LOCALIZATION_KEY]);
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'error' => true,
                'message' => __(
                    'exceptions.system_cant_action',
                    ['action' => __('create'), 'modelName' => __('{{ Str::snake($model) }}')]
                ),
                'status' => Response::HTTP_BAD_REQUEST,
            ];
        }

        DB::commit();

        return $item;
    }

    /**
     * @param {{ Str::studly($model) }} ${{ Str::camel($model) }} {{ Str::studly($model) }}.
     * @param array      $data       Data.
     *
     * @return {{ Str::studly($model) }}Interface|array
     */
    public function update({{ Str::studly($model) }} ${{ Str::camel($model) }}, array $data): array|{{ Str::studly($model) }}Interface
    {
        DB::beginTransaction();

        try {
            $item = ${{ Str::camel($model) }}->updateObject($data);

            /** Sync Multilingual */
            $item = $this->syncMultilingual($item, $data[LocalizableModel::LOCALIZATION_KEY]);
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'error' => true,
                'message' => __(
                    'exceptions.system_cant_action',
                    ['action' => __('update'), 'modelName' => __('{{ Str::snake($model) }}')]
                ),
                'status' => Response::HTTP_BAD_REQUEST,
            ];
        }

        DB::commit();

        return $item;
    }
}
