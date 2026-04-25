<x-app-layout>
    <x-slot name="header">
        <h2>Create Company</h2>
    </x-slot>
<style>
    .btn {
        display: inline-block;
        padding: 8px 14px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        border: 1px solid #2563eb;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .btn:hover {
        background: #1e40af;
    }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="border:1px solid #ccc; padding:20px; width:600px; background:#fff;">

                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf

                    <label>Company Name</label><br>
                    <input type="text" name="name" required><br><br>
                    <button class="btn" type="submit">Create</button>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
