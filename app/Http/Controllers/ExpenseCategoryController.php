<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {

        $expense_categories = ExpenseCategory::orderBy('name')->get();

        return view('pages.expense_categories.index', compact('expense_categories'));
    }

    public function create()
    {
        return view('pages.expense_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_categories|max:255',
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
            'user' => $request->user
        ]);

        return redirect()->route('expense-categories.index')->with('success', 'Расходная категория успешно добавлена');
    }

    public function show(ExpenseCategory $expense_category)
    {
        return view('pages.expense_categories.show', compact('expense_category'));
    }

    public function edit(ExpenseCategory $expense_category)
    {
        return view('pages.expense_categories.edit', compact('expense_category'));
    }

    public function update(Request $request, ExpenseCategory $expense_category)
    {
        $request->validate([
            'name' => 'required|unique:expense_categories,name,' . $expense_category->id . '|max:255',
        ]);

        $expense_category->update([
            'name' => $request->name,
            'user' => $request->user
        ]);

        return redirect()->route('expense-categories.index')->with('success', 'Расходная категория успешно обновлена');
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $expense_category->delete();

        return redirect()->route('expense-categories.index')->with('success', 'Расходная категория успешно удалена');
    }
}
