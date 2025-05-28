<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Set Password
        </h2>
    </x-slot>

    <div class="py-12">
        <form method="POST" action="{{ route('password.set') }}" class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            @csrf
            <div>
                <x-input-label for="password" value="Password Baru" />
                <x-text-input type="password" name="password" id="password" class="block mt-1 w-full" required />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input type="password" name="password_confirmation" id="password_confirmation" class="block mt-1 w-full" required />
            </div>
            <div class="mt-6">
                <x-primary-button class="w-full">
                    Simpan Password
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
