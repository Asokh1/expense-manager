<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Edit Expense</h1>
    <form action="{{ route('expenses.update', $expense) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title', $expense->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input name="amount" type="number" step="0.01" class="form-control" value="{{ old('amount', $expense->amount) }}">
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control">
                @foreach(['Food','Transport','Shopping','Bills','Other'] as $cat)
                    <option {{ $expense->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input name="spent_at" type="date" class="form-control" value="{{ old('spent_at', $expense->spent_at) }}">
        </div>
        <div class="mb-3">
            <label>Notes (optional)</label>
            <textarea name="notes" class="form-control">{{ old('notes', $expense->notes) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>