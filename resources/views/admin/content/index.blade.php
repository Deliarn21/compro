@extends('admin.layouts.app')

@section('meta_title', $sectionConfig['label'].' | Hasnur Group Admin')

@section('content')
    <div class="hsnr-admin__header">
        <div>
            <p class="hsnr-eyebrow">Content Section</p>
            <h1>{{ $sectionConfig['label'] }}</h1>
            <p>{{ $sectionConfig['description'] }}</p>
        </div>
        <a class="hsnr-button" href="{{ route('admin.contents.create', $sectionKey) }}">Tambah {{ $sectionConfig['singular'] }}</a>
    </div>

    @if ($sectionKey === 'publications')
        <div class="hsnr-filter-row">
            <a @class(['is-active' => ! request('category')]) href="{{ route('admin.contents.index', $sectionKey) }}">Semua</a>
            @foreach ($sectionConfig['categories'] as $value => $label)
                <a @class(['is-active' => request('category') === $value]) href="{{ route('admin.contents.index', ['section' => $sectionKey, 'category' => $value]) }}">{{ $label }}</a>
            @endforeach
        </div>
    @endif

    <div class="hsnr-panel">
        <div class="hsnr-admin__table-wrap">
            <table class="hsnr-admin__table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug / Parent</th>
                        <th>Category</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contents as $content)
                        <tr>
                            <td>
                                <strong>{{ $content->title }}</strong>
                                <div>{{ $content->subtitle }}</div>
                            </td>
                            <td>
                                {{ $content->slug ?: '-' }}
                                @if ($content->parent)
                                    <div>Parent: {{ $content->parent->title }}</div>
                                @endif
                            </td>
                            <td>{{ $content->category ?: '-' }}</td>
                            <td>{{ $content->updated_at->format('d M Y H:i') }}</td>
                            <td class="hsnr-admin__actions">
                                <a href="{{ route('admin.contents.edit', [$sectionKey, $content]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.contents.destroy', [$sectionKey, $content]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus item ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada data pada section ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
