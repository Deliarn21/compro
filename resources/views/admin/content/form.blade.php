@extends('admin.layouts.app')

@section('meta_title', ($content->exists ? 'Edit ' : 'Tambah ').$sectionConfig['singular'].' | Hasnur Group Admin')

@section('content')
    <div class="hsnr-admin__header">
        <div>
            <p class="hsnr-eyebrow">Content Editor</p>
            <h1>{{ $content->exists ? 'Edit' : 'Tambah' }} {{ $sectionConfig['singular'] }}</h1>
        </div>
    </div>

    <form class="hsnr-form hsnr-form--admin" method="POST" action="{{ $content->exists ? route('admin.contents.update', [$sectionKey, $content]) : route('admin.contents.store', $sectionKey) }}">
        @csrf
        @if ($content->exists)
            @method('PUT')
        @endif

        <div class="hsnr-form__grid">
            <label>
                <span>Title</span>
                <input type="text" name="title" value="{{ old('title', $content->title) }}" required>
            </label>

            <label>
                <span>Slug</span>
                <input type="text" name="slug" value="{{ old('slug', $content->slug) }}">
            </label>

            <label>
                <span>Subtitle</span>
                <input type="text" name="subtitle" value="{{ old('subtitle', $content->subtitle) }}">
            </label>

            <label>
                <span>Image Path</span>
                <input type="text" name="image_path" value="{{ old('image_path', $content->image_path) }}">
            </label>
        </div>

        @if (! empty($sectionConfig['categories']))
            <label>
                <span>Category</span>
                <select name="category" required>
                    <option value="">Pilih category</option>
                    @foreach ($sectionConfig['categories'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $content->category) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        @endif

        @if ($sectionConfig['supports_parent'])
            <label>
                <span>Parent Business Unit</span>
                <select name="parent_id">
                    <option value="">Pilih parent</option>
                    @foreach ($businessUnitOptions as $option)
                        <option value="{{ $option->id }}" @selected((string) old('parent_id', $content->parent_id) === (string) $option->id)>{{ $option->title }}</option>
                    @endforeach
                </select>
            </label>
        @endif

        <label>
            <span>Summary</span>
            <textarea name="summary" rows="4">{{ old('summary', $content->summary) }}</textarea>
        </label>

        <label>
            <span>Body (HTML allowed)</span>
            <textarea name="body" rows="10">{{ old('body', $content->body) }}</textarea>
        </label>

        <div class="hsnr-form__grid">
            <label>
                <span>Meta Title</span>
                <input type="text" name="meta_title" value="{{ old('meta_title', $content->meta_title) }}">
            </label>
            <label>
                <span>Legacy Path</span>
                <input type="text" name="legacy_path" value="{{ old('legacy_path', $content->legacy_path) }}">
            </label>
            <label>
                <span>Link URL</span>
                <input type="text" name="link_url" value="{{ old('link_url', $content->link_url) }}">
            </label>
            <label>
                <span>Sort Order</span>
                <input type="number" name="sort_order" value="{{ old('sort_order', $content->sort_order ?? 0) }}">
            </label>
        </div>

        <label>
            <span>Meta Description</span>
            <textarea name="meta_description" rows="3">{{ old('meta_description', $content->meta_description) }}</textarea>
        </label>

        <div class="hsnr-form__grid">
            <label>
                <span>Published At</span>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($content->published_at)->format('Y-m-d\TH:i')) }}">
            </label>

            <label class="hsnr-checkbox hsnr-checkbox--boxed">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $content->is_published ?? true) ? 'checked' : '' }}>
                <span>Published</span>
            </label>
        </div>

        @switch($sectionKey)
            @case('pages')
                <div class="hsnr-form__grid">
                    <label><span>Highlight</span><input type="text" name="extra_highlight" value="{{ old('extra_highlight', $content->extraValue('highlight')) }}"></label>
                    <label><span>CTA Label</span><input type="text" name="extra_cta_label" value="{{ old('extra_cta_label', $content->extraValue('cta_label')) }}"></label>
                    <label><span>CTA URL</span><input type="text" name="extra_cta_url" value="{{ old('extra_cta_url', $content->extraValue('cta_url')) }}"></label>
                </div>
                @break
            @case('business-units')
                <div class="hsnr-form__grid">
                    <label><span>Theme</span><input type="text" name="extra_theme" value="{{ old('extra_theme', $content->extraValue('theme')) }}"></label>
                    <label><span>Accent Color</span><input type="text" name="extra_accent" value="{{ old('extra_accent', $content->extraValue('accent')) }}"></label>
                </div>
                @break
            @case('business-entities')
                <div class="hsnr-form__grid">
                    <label><span>Entity Code</span><input type="text" name="extra_code" value="{{ old('extra_code', $content->extraValue('code')) }}"></label>
                    <label><span>Website</span><input type="text" name="extra_website" value="{{ old('extra_website', $content->extraValue('website')) }}"></label>
                </div>
                @break
            @case('milestones')
                <label><span>Year</span><input type="text" name="extra_year" value="{{ old('extra_year', $content->extraValue('year')) }}"></label>
                @break
            @case('executives')
                <div class="hsnr-form__grid">
                    <label><span>Role</span><input type="text" name="extra_role" value="{{ old('extra_role', $content->extraValue('role')) }}"></label>
                    <label><span>Division</span><input type="text" name="extra_division" value="{{ old('extra_division', $content->extraValue('division')) }}"></label>
                </div>
                @break
            @case('csr-pillars')
                <div class="hsnr-form__grid">
                    <label><span>Icon</span><input type="text" name="extra_icon" value="{{ old('extra_icon', $content->extraValue('icon')) }}"></label>
                    <label><span>Impact</span><input type="text" name="extra_impact" value="{{ old('extra_impact', $content->extraValue('impact')) }}"></label>
                </div>
                @break
            @case('publications')
                <div class="hsnr-form__grid">
                    <label><span>Author</span><input type="text" name="extra_author" value="{{ old('extra_author', $content->extraValue('author')) }}"></label>
                    <label><span>Source</span><input type="text" name="extra_source" value="{{ old('extra_source', $content->extraValue('source')) }}"></label>
                </div>
                @break
            @case('locations')
                <div class="hsnr-form__grid">
                    <label><span>Phone</span><input type="text" name="extra_phone" value="{{ old('extra_phone', $content->extraValue('phone')) }}"></label>
                    <label><span>Email</span><input type="text" name="extra_email" value="{{ old('extra_email', $content->extraValue('email')) }}"></label>
                    <label><span>Map Link</span><input type="text" name="extra_map_link" value="{{ old('extra_map_link', $content->extraValue('map_link')) }}"></label>
                    <label><span>Office Hours</span><input type="text" name="extra_office_hours" value="{{ old('extra_office_hours', $content->extraValue('office_hours')) }}"></label>
                </div>
                @break
        @endswitch

        <div class="hsnr-form__actions">
            <button class="hsnr-button" type="submit">Simpan</button>
            <a class="hsnr-button hsnr-button--ghost" href="{{ route('admin.contents.index', $sectionKey) }}">Batal</a>
        </div>
    </form>
@endsection
