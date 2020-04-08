<?php

namespace Tessify\Core\Commands;

use Elasticsearch;
use Illuminate\Console\Command;
use Tessify\Core\Models\Project;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all searchable data to Elasticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Indexing all articles. This might take a while...");

        foreach (Project::all() as $project)
        {
            Elasticsearch::index([
                "index" => $project->getSearchIndex(),
                "type" => $project->getSearchType(),
                "id" => $project->getKey(),
                "body" => $project->toSearchArray()
            ]);
            
            $this->output->write('.');
        }

        $this->info("\nDone!");
    }
}
