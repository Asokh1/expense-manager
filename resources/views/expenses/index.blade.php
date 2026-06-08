<!DOCTYPE html>
<html>
<head>
    <title>Expense Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Expenses</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">+ Add Expense</a>
    </div>

    <form method="GET" action="{{ route('expenses.index') }}" class="d-flex gap-2 mb-4 align-items-center">
    <input type="date" name="date" class="form-control w-auto" value="{{ request('date') }}">
    <select name="category" class="form-control w-auto">
        <option value="">All Categories</option>
        <option value="Food" {{ request('category') == 'Food' ? 'selected' : '' }}>Food</option>
        <option value="Transport" {{ request('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
        <option value="Shopping" {{ request('category') == 'Shopping' ? 'selected' : '' }}>Shopping</option>
        <option value="Bills" {{ request('category') == 'Bills' ? 'selected' : '' }}>Bills</option>
        <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Clear</a>
</form>

<div class="alert alert-info mb-4">
    <strong>Total:</strong> ¥{{ number_format($total, 2) }}
</div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th><th>Amount</th><th>Category</th><th>Date</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td>{{ $expense->title }}</td>
                <td>¥{{ number_format($expense->amount, 2) }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ $expense->spent_at }}</td>
                <td>
                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr><td colspan="5" class="text-center">No expenses yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>