<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="page-title">Invite New Client</h2>
            <p class="page-subtitle">Create a client account invitation with the primary contact details.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="notice-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="notice-success">{{ session('success') }}</div>
            @endif

            <section class="surface">
                <div class="surface-header">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-950">Client Details</h3>
                        <p class="mt-1 text-sm text-slate-500">The invited client will use this name and email to get started.</p>
                    </div>
                </div>

                <form action="{{ route('companies.invite') }}" method="POST" class="surface-body space-y-5">
                    @csrf

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="field-label" for="name">Name</label>
                            <input
                                id="name"
                                class="field-control"
                                type="text"
                                name="name"
                                placeholder="Client name"
                                required
                            >
                        </div>

                        <div>
                            <label class="field-label" for="email">Email</label>
                            <input
                                id="email"
                                class="field-control"
                                type="email"
                                name="email"
                                placeholder="sample@example.com"
                                required
                            >
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button class="btn" type="submit">Send Invitation</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
