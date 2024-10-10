<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\search;
use App\Models\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Laravel\Prompts\confirm;

class SendEmails extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    //Console name command
    protected $signature = 'app:send-emails {user* : The IDs of the user} {--Q|queue=default : whether the job should be queued}';


    //Console description
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        //Console choice
        $name = $this->choice(
            'What is your name?',
            ['Taylor', 'Dayle'],
            1,
            $maxAttempts = 4,
            $allowMultipleSelections = true
        );

        //Console secrect
        $password = $this->secret('What is the password?');


        //Console progress bar
        $usersProgressBar = $this->withProgressBar(User::all(), function (User $user) {
            
        });

        //Console confrim
        if ($this->confirm('Do you wish to continue?',true)) {
            $users = $this->argument('user');
            foreach($users as $user){
                $this->info("Send email to the {$name[0]}!");
            }
        } else {
            //Console Table
            $this->table(
                ['Name', 'Email'],
                User::all(['name', 'email'])->toArray()
            );
        }
        return 0;
    }


    //Console after prompt missing
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'user' => fn () => search(
                label: 'Search for a user:',
                placeholder: 'E.g. Taylor Otwell',
                options: fn ($value) => strlen($value) > 0
                    ? User::where('name', 'like', "%{$value}%")->pluck('name', 'id')->all()
                    : []
            ),
        ];
    }

    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output): void
    {
        $input->setOption('queue', confirm(
            label: 'Would you like to queue the mail?',
            default: $this->option('queue')
        ));
    }
}
