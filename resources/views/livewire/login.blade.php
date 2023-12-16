<div class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Tontine</b>Burkina</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Connexion</p>

                <form wire:submit='login' class="mb-2">
                    <div class="input-group mb-3">
                        <input wire:model='phone_number' type="number"
                            class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            placeholder="Nom" value="{{ old('phone_number') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input wire:model='password' type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Mot de passe" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div wire:model='remember' class="icheck-primary">
                                <input type="checkbox" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">j'ai oublié mon mot de passe</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" wire:navigate class="text-center">Créer un compte</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>
