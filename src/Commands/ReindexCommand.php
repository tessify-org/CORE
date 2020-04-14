<?php

namespace Tessify\Core\Commands;

use Elasticsearch;

use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Ministry;
use Tessify\Core\Models\Organization;

use Illuminate\Console\Command;

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
        // Intro
        $this->info("Started indexing, this might take a while...");

        // Index users
        $this->info("Indexing all users.");
        foreach (User::all() as $user)
        {
            Elasticsearch::index([
                "index" => $user->getSearchIndex(),
                "type" => $user->getSearchType(),
                "id" => $user->getKey(),
                "body" => $user->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->output->write("\n");

        // Index projects
        $this->info("Indexing all projects.");
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
        $this->output->write("\n");

        // Index tasks
        $this->info("Indexing all tasks.");
        foreach (Task::all() as $task)
        {
            Elasticsearch::index([
                "index" => $task->getSearchIndex(),
                "type" => $task->getSearchType(),
                "id" => $task->getKey(),
                "body" => $task->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->output->write("\n");

        // Index ministries
        $this->info("Indexing all ministries");
        foreach (Ministry::all() as $ministry)
        {
            Elasticsearch::index([
                "index" => $ministry->getSearchIndex(),
                "type" => $ministry->getSearchType(),
                "id" => $ministry->getKey(),
                "body" => $ministry->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->output->write("\n");

        // Index organizations
        $this->info("Indexing all organizations");
        foreach (Organization::all() as $organization)
        {
            Elasticsearch::index([
                "index" => $organization->getSearchIndex(),
                "type" => $organization->getSearchType(),
                "id" => $organization->getKey(),
                "body" => $organization->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->output->write("\n");

        // Finished!
        $this->info("Done!");
    }
}
