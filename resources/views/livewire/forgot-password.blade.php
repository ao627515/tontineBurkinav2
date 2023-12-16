<div class="login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Tontine</b>Burkina</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Mot de passe oublié ? Vous pouvez facilement récupérer un nouveau mot de passe
                    ici.</p>
                <form wire:submit='sendPasswordResetLink'>
                    <div class="input-group mb-3">
                        <input wire:model='email' type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Email" required>
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
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Demander un nouveau mot de
                                passe</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" wire:navigate>Connexion</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
