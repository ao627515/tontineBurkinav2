<div class="login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Tontine</b>Burkina</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">À un pas de votre nouveau mot de passe, récupérez-le maintenant.</p>
                <form wire:submit='resetPassword'>
                    {{-- Email --}}
                    <div class="input-group mb-3">
                        <input wire:model='email' type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Mot de passe --}}
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
                    {{-- Confirme le mot de passe --}}
                    <div class="input-group mb-3">
                        <input wire:model='password_confirmation' type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Changé de mot de passe</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" wire:navigate >Connexion</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>
