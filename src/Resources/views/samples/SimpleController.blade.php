{!! '<?php' !!}

namespace App\Http\Controllers;

use App\Filters\{{ Str::studly($model) }}Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\{{ Str::studly($model) }}Request;
use App\Http\Resources\{{ Str::studly($model) }}Resource;
use App\Models\{{ Str::studly($model) }};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class {{ Str::studly($model) }}Controller extends Controller
{
    /**
     * @param {{ Str::studly($model) }}Filter $filters Filters.
     * @param Request     $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function index({{ Str::studly($model) }}Filter $filters, Request $request): AnonymousResourceCollection
    {
        return {{ Str::studly($model) }}Resource::collection({{ Str::studly($model) }}::filter($filters)->paginate($this->getPageSize($request)));
    }

    /**
     * @param {{ Str::studly($model) }}Request $request {{ Str::studly($model) }}Request.
     *
     * @return {{ Str::studly($model) }}Resource
     */
    public function store({{ Str::studly($model) }}Request $request): {{ Str::studly($model) }}Resource
    {
        ${{ Str::camel($model) }} = {{ Str::studly($model) }}::createObject($request->validated());

        return new {{ Str::studly($model) }}Resource(${{ Str::camel($model) }});
    }

    /**
     * @param {{ Str::studly($model) }} ${{ Str::camel($model) }} {{ Str::studly($model) }}.
     *
     * @return {{ Str::studly($model) }}Resource
     */
    public function show({{ Str::studly($model) }} ${{ Str::camel($model) }}): {{ Str::studly($model) }}Resource
    {
        return new {{ Str::studly($model) }}Resource(${{ Str::camel($model) }});
    }

    /**
     * @param {{ Str::studly($model) }}Request $request {{ Str::studly($model) }}Request.
     * @param {{ Str::studly($model) }}        ${{ Str::camel($model) }}   {{ Str::studly($model) }}.
     *
     * @return {{ Str::studly($model) }}Resource
     */
    public function update({{ Str::studly($model) }}Request $request, {{ Str::studly($model) }} ${{ Str::camel($model) }}): {{ Str::studly($model) }}Resource
    {
        ${{ Str::camel($model) }}->updateObject($request->validated());

        return new {{ Str::studly($model) }}Resource(${{ Str::camel($model) }});
    }

    /**
     * @param {{ Str::studly($model) }} ${{ Str::camel($model) }} {{ Str::studly($model) }}.
     *
     * @return JsonResponse
     */
    public function destroy({{ Str::studly($model) }} ${{ Str::camel($model) }}): JsonResponse
    {
        try {
            ${{ Str::camel($model) }}->delete();

            return $this->getResponse([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            Log::error('Delete {{ Str::studly($model) }} Error : ' . $exception->getMessage());

            return $this->getResponse([], Response::HTTP_CONFLICT);
        }
    }
}
