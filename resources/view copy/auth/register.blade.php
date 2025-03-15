<x-layout>
    <section class="bg-white min-h-screen flex items-center justify-center antialiased">
        <div class="w-full max-w-xl bg-white rounded-xl shadow-lg dark:border border-black/10 px-10 py-12">
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-6">
                Create an Account
            </h1>

            <x-forms.form method="POST" action="/register">
                <div class="space-y-5">
                    <div>
                        <x-forms.input label="Name" name="name" placeholder="Enter your Full Name"/>
                    </div>
                    <div>
                        <x-forms.input label="Email" name="email" type="email" placeholder="Enter your Email" />
                    </div>
                    <div>
                        <x-forms.input label="Password" name="password" type="password" placeholder="Enter your Password" />
                    </div>
                    <div>
                        <x-forms.input label="Confirm Password" name="password_confirmation" type="password" placeholder="Confirm your Password" />
                    </div>
                </div>

                <x-forms.button>
                    Create Account
                </x-forms.button>

                <p class="text-sm text-gray-600 mt-4 text-center">
                    Already have an account? 
                    <a href="/login" class="text-green-600 hover:underline">Sign in</a>
                </p>
            </x-forms.form>
        </div>
    </section>
</x-layout>
