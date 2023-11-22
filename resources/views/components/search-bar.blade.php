<div>
    <div class="input-group input-group-lg">
    <input {{ $attributes }} type="search" name="search" id="search" class="form-control form-control-lg @error('description') is-invalid @enderror" placeholder="Type your keywords here">
        <div class="input-group-append">
            <button type="submit" class="btn btn-lg btn-default">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    @error('search')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
