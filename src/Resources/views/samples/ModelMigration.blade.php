{!! '<?php' !!}

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{{Str::of($model)->studly()->plural()}}Table extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create({{Str::of($model)->studly()}}::TABLE, function (Blueprint $table) {
            $table->id();
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FOREIGN)
        $table->foreignId( {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper()}})->constrained();
    @endif
@endforeach
@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_STRING)
        $table->string( {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper()}});
    @endif
@endforeach

@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_INTEGER)
        $table->integer( {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper()}});
    @endif
@endforeach

@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_FLOAT)
        $table->float( {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper()}});
    @endif
@endforeach

@foreach($columns as $column)
    @if($column['type'] == \CG\Generators\CodeGenerator::COLUMN_BOOLEAN)
        $table->boolean( {{ Str::studly($model) }}::{{ Str::of($column['fieldName'])->snake()->upper()}});
    @endif
@endforeach
            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists({{Str::of($model)->studly()}}::TABLE);
    }
}
