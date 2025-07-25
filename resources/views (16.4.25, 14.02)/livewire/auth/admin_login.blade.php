<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <img src="{{asset('/img/cam-ranh-2.jpg')}}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Website Management!</h1>
                                </div>
                                <form wire:submit.prevent="login">
                                    @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="exampleInputEmail" class="form-label">Email Address</label>
                                        <input wire:model="email" type="email" class="form-control" id="exampleInputEmail"
                                            placeholder="Enter Email Address...">
                                        @error('email') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword" class="form-label">Password</label>
                                        <input wire:model.lazy="password" type="password" class="form-control"
                                            id="exampleInputPassword" placeholder="Password">
                                        @error('password') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input wire:model="remember_me" type="checkbox" class="form-check-input" id="customCheck">
                                        <label class="form-check-label" for="customCheck">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        Login
                                    </button>
                                    <hr>
                                    <button type="button" class="btn btn-danger w-100">
                                        <i class="fab fa-google"></i> Login with Google
                                    </button>
                                    <button type="button" class="btn btn-primary w-100 mt-2">
                                        <i class="fab fa-facebook-f"></i> Login with Facebook
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register.html">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if email is stored in localStorage
        const savedEmail = localStorage.getItem('remembered_email');
        if (savedEmail) {
            @this.set('email', savedEmail);
        }

        // Handle email storage on form submission
        document.querySelector('form').addEventListener('submit', function () {
            const rememberMe = document.querySelector('#customCheck').checked;
            const email = document.querySelector('#exampleInputEmail').value;

            if (rememberMe) {
                localStorage.setItem('remembered_email', email);
            } else {
                localStorage.removeItem('remembered_email');
            }
        });
    });
</script>
@endsection