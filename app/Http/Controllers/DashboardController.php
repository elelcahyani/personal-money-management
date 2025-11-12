<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Goal;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Get filter parameters
        $period = $request->get('period', '30days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Calculate date range
        if ($period == 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            $end = Carbon::now()->endOfDay();
            $start = match($period) {
                '7days' => Carbon::now()->subDays(6)->startOfDay(),
                '30days' => Carbon::now()->subDays(29)->startOfDay(),
                '90days' => Carbon::now()->subDays(89)->startOfDay(),
                '1year' => Carbon::now()->subYear()->startOfDay(),
                default => Carbon::now()->subDays(29)->startOfDay(),
            };
        }
        
        // Store formatted dates for form
        $startDate = $start->format('Y-m-d');
        $endDate = $end->format('Y-m-d');
        
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
            
        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');
            
        $balance = $totalIncome - $totalExpense;
        
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();
            
        $activeGoals = Goal::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        // Get chart data
        $chartData = $this->getChartData($user->id, $start, $end);

        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense', 
            'balance', 
            'recentTransactions', 
            'activeGoals',
            'chartData',
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function getChartData($userId, $start, $end)
    {
        // Get all transactions in the date range
        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->orderBy('transaction_date')
            ->get();

        $dates = [];
        $incomeData = [];
        $expenseData = [];
        
        $current = $start->copy()->startOfDay();
        $endDate = $end->copy()->endOfDay();
        
        while ($current <= $endDate) {
            $dateStr = $current->format('Y-m-d');
            $dates[] = $current->format('d M');
            
            // Filter transactions for this specific date
            $dayIncome = $transactions->filter(function($transaction) use ($dateStr) {
                return $transaction->transaction_date->format('Y-m-d') === $dateStr && $transaction->type === 'income';
            })->sum('amount');
            
            $dayExpense = $transactions->filter(function($transaction) use ($dateStr) {
                return $transaction->transaction_date->format('Y-m-d') === $dateStr && $transaction->type === 'expense';
            })->sum('amount');
            
            $incomeData[] = (float) $dayIncome;
            $expenseData[] = (float) $dayExpense;
            
            $current->addDay();
        }

        return [
            'labels' => $dates,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    public function export(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $filename = 'transaksi_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(
            new TransactionsExport($user->id, $startDate, $endDate),
            $filename
        );
    }
}
