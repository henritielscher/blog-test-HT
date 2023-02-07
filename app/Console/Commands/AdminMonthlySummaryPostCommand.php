<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Exception;
use Faker\Provider\Lorem;
use Illuminate\Console\Command;

class AdminMonthlySummaryPostCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:summary-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a summary post by the admin';

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
     * @return int
     */
    public function handle()
    {
        /** @var User|null */
        $admin = User::all()->where("is_admin", "=", 1)->first();

        if (!$admin) {
            throw new Exception("There is currently no administrator user in the Database.");
        }

        $date = Carbon::now()->subMonth()->format("m.Y");

        $post = new Post();
        $post->title = "Zusammenfassung Monat " . $date;
        $post->body = Lorem::paragraph();
        $post->category_id = random_int(1, 10);

        $admin->posts()->save($post);

        return 0;
    }
}
