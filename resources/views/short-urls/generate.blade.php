<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="page-title">Generate Short URL</h2>
            <p class="page-subtitle">Paste a destination link and create a compact tracking URL.</p>
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
                        <h3 class="text-lg font-semibold text-slate-950">New Short Link</h3>
                        <p class="mt-1 text-sm text-slate-500">Use the full URL, including https://, for the best redirect behavior.</p>
                    </div>
                </div>

                <form action="{{ route('urls.generate') }}" method="POST" class="surface-body space-y-5">
                    @csrf

                    <div>
                        <label class="field-label" for="original_url">Long URL</label>
                        <input
                            id="original_url"
                            class="field-control"
                            type="text"
                            name="original_url"
                            placeholder="https://sembark.com/travel-software/feature/flight-booking"
                            required
                        >
                    </div>

                    <div class="flex justify-end">
                        <button class="btn" type="submit">Generate</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
