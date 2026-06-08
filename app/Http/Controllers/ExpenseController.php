<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'category' => 'required|string',
            'spent_at' => 'required|date',
        ]);

        Expense::create($request->only('title', 'amount', 'category', 'spent_at', 'notes'));

        return redirect()->route('expenses.index')->with('success', 'Expense added!');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'category' => 'required|string',
            'spent_at' => 'required|date',
        ]);

        $expense->update($request->only('title', 'amount', 'category', 'spent_at', 'notes'));

        return redirect()->route('expenses.index')->with('success', 'Expense updated!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted!');
    }

    public function index(Request $request)
    {
        $query = Expense::latest();

        if ($request->filled('date')) {
            $query->whereDate('spent_at', $request->date);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $total = $query->sum('amount');
        $expenses = $query->get();

        $currency = $request->get('currency', 'JPY');
        $rate = 1;

        if ($currency !== 'JPY') {
            $response = Http::get("https://api.frankfurter.app/latest", [
                'from' => 'JPY',
                'to' => $currency,
            ]);
            $rate = $response->json('rates')[$currency];
        }

        return view('expenses.index', compact('expenses', 'total', 'currency', 'rate'));
    }
}