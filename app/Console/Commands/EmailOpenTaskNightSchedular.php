<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailOpenTaskNightSchedular extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:openTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open Tasks ';

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

        User::whereBirthDate(date('m/d'))->get(); 

        foreach( $users as $user ) {
          if($user->has('email')) {
          SMS::to($user->email)
             ->msg('Dear ' . $user->name . ', You got an Open Task!')
             ->send();
          }   
      }        
      $this->info('New recieved Notification');
        // return Command::SUCCESS;
    }
}
