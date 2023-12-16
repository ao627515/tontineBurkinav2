<div class="register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Tontine</b>Burkina</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Inscriptions</p>

                <form wire:submit='register'>
                    {{-- Nom --}}
                    <div class="input-group mb-3">
                        <input wire:model='last_name' type="text"
                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                            placeholder="Nom" value="{{ old('last_name') }}" required >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Prenom --}}
                    <div class="input-group mb-3">
                        <input wire:model='first_name' type="text"
                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                            placeholder="Prénom(s)" value="{{ old('first_name') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Telephone --}}
                    <div class="input-group mb-3">
                        <input wire:model='phone_number' type="number"
                            class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            placeholder="Téléphone" value="{{ old('phone_number') }}" required>
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
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input wire:model='terms' type="checkbox" id="agreeTerms" name="terms" value="agree"
                                    class="form-check-input @error('terms') is-invalid @enderror">
                                <label for="agreeTerms" class="form-check-label">
                                    I agree to the <a href="#" class="text-decoration-none">terms</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="{{ route('login') }}" wire:navigate class="text-center">J'ai déjà un compte</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
</div>
<!-- /.register-box -->
