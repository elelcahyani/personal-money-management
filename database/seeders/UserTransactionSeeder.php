<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Carbon\Carbon;

class UserTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user (your user)
        $userId = 1; // ellldwc@gmail.com

        // Delete old transactions for this user
        Transaction::where('user_id', $userId)->delete();

        // Create sample transactions for the last 30 days
        $categories = [
            'income' => ['Gaji', 'Freelance', 'Investasi', 'Bonus'],
            'expense' => ['Makanan', 'Transport', 'Belanja', 'Tagihan', 'Hiburan']
        ];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Random income (1-3 per week)
            if (rand(1, 7) <= 3) {
                Transaction::create([
                    'user_id' => $userId,
                    'type' => 'income',
                    'amount' => rand(100000, 5000000),
                    'category' => $categories['income'][array_rand($categories['income'])],
                    'description' => 'Sample income transaction',
                    'transaction_date' => $date,
                ]);
            }

            // Random expenses (1-5 per day)
            $expenseCount = rand(1, 5);
            for ($j = 0; $j < $expenseCount; $j++) {
                Transaction::create([
                    'user_id' => $userId,
                    'type' => 'expense',
                    'amount' => rand(10000, 500000),
                    'category' => $categories['expense'][array_rand($categories['expense'])],
                    'description' => 'Sample expense transaction',
                    'transaction_date' => $date,
                ]);
            }
        }

        echo "Created transactions for user ID $userId\n";
    }
}
