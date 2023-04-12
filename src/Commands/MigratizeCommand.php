<?php

namespace Smousss\Laravel\Migratize\Commands;

use ReflectionClass;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class MigratizeCommand extends Command
{
    protected $signature = 'smousss:migratize {model?*}';

    protected $description = 'Create missing migrations';

    public function handle() : int
    {
        if (empty(config('migratize.secret_key'))) {
            $this->error('Please generate a secret key on smousss.com and add it to your .env file as SMOUSSS_SECRET_KEY.');

            return self::FAILURE;
        }

        $tables = $this->getTables();

        $choice = $this->choice('Do you want to choose the tables you need a migration for?', [
            'Choose the files',
            'Generate a migration for all the tables!',
        ], 0);

        if ($choice === 'Choose the files') {
            $tables = Arr::wrap(
                $this->choice('For which table do you need a migration?', $tables->toArray(), multiple: true)
            );
        }

        foreach ($tables as $table) {
            $schema = $this->getTableSchema($table);

            $this->line("GPT-4 is generating the migration for {$table}…");

            $response = Http::withToken(config('migratize.secret_key'))
                ->timeout(300)
                ->retry(3)
                ->post(config('migratize.debug', false)
                    ? 'https://smousss.test/api/migratize'
                    : 'https://smousss.com/api/migratize', compact('schema'))
                ->throw()
                ->json();

            File::put(base_path($path = 'database/migrations/' . date('Y_m_d_His') . "_create_{$table}_table.php"), trim(trim($response['data'], '`ph')) . PHP_EOL);

            $this->info("Your migration has been created at $path! 🎉 (Tokens: {$response['meta']['consumed_tokens']})");
        }

        return self::SUCCESS;
    }

    protected function getSourceCodeForModel(Model $model) : string
    {
        $sourceCode = File::get((new ReflectionClass($model::class))->getFileName());

        $sourceCode = str_replace("\t", '', $sourceCode);
        $sourceCode = str_replace("\n", ' ', $sourceCode);

        return preg_replace('/ {2,}/', ' ', $sourceCode);
    }

    protected function getTables() : Collection
    {
        return collect(DB::connection()->getDoctrineSchemaManager()->listTableNames())
            ->reject(fn ($v) => in_array($v, ['action_events', 'migrations']));
    }

    protected function getTableSchema(string $table) : string
    {
        return collect(DB::getDoctrineConnection()->getDatabasePlatform()->getCreateTableSQL(
            DB::getDoctrineSchemaManager()->introspectTable($table)
        ))->implode('; ');
    }
}
