@extends('admin.layouts.app')

@section('meta_title', ($redirect->exists ? 'Edit' : 'Tambah').' Redirect | Hasnur Group Admin')

@section('content')
    <div class="hsnr-admin__header">
        <div>
            <p class="hsnr-eyebrow">Redirect Editor</p>
            <h1>{{ $redirect->exists ? 'Edit' : 'Tambah' }} Redirect</h1>
        </div>
    </div>

    <form class="hsnr-form hsnr-form--admin" method="POST" action="{{ $redirect->exists ? route('admin.redirects.update', $redirect) : route('admin.redirects.store') }}">
        @csrf
        @if ($redirect->exists)
            @method('PUT')
        @endif

        <label>
            <span>Old Path</span>
            <input type="text" name="old_path" value="{{ old('old_path', $redirect->old_path) }}" required>
        </label>

        <label>
            <span>New Path</span>
            <input type="text" name="new_path" value="{{ old('new_path', $redirect->new_path) }}" required>
        </label>

        <div class="hsnr-form__grid">
            <label>
                <span>Status Code</span>
                <select name="status_code">
                    <option value="301" @selected(old('status_code', $redirect->status_code) == 301)>301</option>
                    <option value="302" @selected(old('status_code', $redirect->status_code) == 302)>302</option>
                </select>
            </label>

            <label class="hsnr-checkbox hsnr-checkbox--boxed">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $redirect->is_active ?? true) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>

        <label>
            <span>Notes</span>
            <textarea name="notes" rows="4">{{ old('notes', $redirect->notes) }}</textarea>
        </label>

        <div class="hsnr-form__actions">
            <button class="hsnr-button" type="submit">Simpan</button>
            <a class="hsnr-button hsnr-button--ghost" href="{{ route('admin.redirects.index') }}">Batal</a>
        </div>
    </form>
@endsection
