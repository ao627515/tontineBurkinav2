<div>
    <div class="input-group">
        <input {{ $attributes }} type="search" class="form-control @error('search') is-invalid @enderror">
        <div class="input-group-append">
            <button type="submit" class="btn btn-default px-3">
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
