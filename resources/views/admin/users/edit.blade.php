@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-4">Edit User Role</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">{{ $user->name }}</div>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="{{ \App\Models\User::ROLE_ATTENDANT }}" {{ $user->role === \App\Models\User::ROLE_ATTENDANT ? 'selected' : '' }}>Attendant</option>
                <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ $user->role === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
