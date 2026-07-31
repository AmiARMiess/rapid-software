<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" @input="setEmailAddress" class="block mt-1 w-full"
                v-bind:class="{ 'bg-danger-soft border border-danger-subtle text-fg-danger-strong text-sm rounded-base focus:ring-danger focus:border-danger block w-full px-3 py-2.5 shadow-xs placeholder:text-fg-danger-strong': v$.emailAddress.$dirty && v$.emailAddress.$invalid }"
                type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <div v-if="v$.emailAddress.$dirty && v$.emailAddress.$invalid" class="invalid-feedback d-block">
                <div v-if="v$.emailAddress.required.$invalid">Email is required</div>
                <div v-if="v$.emailAddress.email.$invalid">Email must be a valid</div>
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
<!--  Vuelidate -->
<script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
<script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
<script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>

<script>
    const {
        createApp,
        ref
    } = window.Vue;
    const {
        useVuelidate
    } = window.Vuelidate;
    const {
        required,
        email,
        numeric,
        between
    } = window.VuelidateValidators;

    createApp({
        setup() {
            const emailAddress = ref(@json(old('email')));
            const age = ref(null);

            const v$ = useVuelidate({
                emailAddress: {
                    required,
                    email,
                },
                age: {
                    numeric,
                    between: between(20, 30)
                }
            }, {
                emailAddress,
                age
            });

            const setEmailAddress = ($event) => {
                emailAddress.value = $event.target.value.trim();
                v$.value.emailAddress.$touch();
            };

            const setAge = ($event) => {
                age.value = $event.target.value;
                v$.value.age.$touch();
            };

            return {
                emailAddress,
                age,
                v$,
                setEmailAddress,
                setAge
            };
        }
    }).mount('#login-form');
</script>
