@extends('admin.layouts.app')

@section('meta_title', 'Redirects | Hasnur Group Admin')

@section('content')
    <div class="hsnr-admin__header">
        <div>
            <p class="hsnr-eyebrow">Legacy Redirects</p>
            <h1>Redirect 301 untuk menjaga jejak URL lama.</h1>
        </div>
        <a class="hsnr-button" href="{{ route('admin.redirects.create') }}">Tambah Redirect</a>
    </div>

    <div class="hsnr-panel">
        <div class="hsnr-admin__table-wrap">
            <table class="hsnr-admin__table">
                <thead>
                    <tr><th>Old Path</th><th>New Path</th><th>Status</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($redirects as $redirect)
                        <tr>
                            <td>{{ $redirect->old_path }}</td>
                            <td>{{ $redirect->new_path }}</td>
                            <td>{{ $redirect->status_code }}</td>
                            <td class="hsnr-admin__actions">
                                <a href="{{ route('admin.redirects.edit', $redirect) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.redirects.destroy', $redirect) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus redirect ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada redirect legacy.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
