@extends('bloglayout')

@section('title', $post->title . ' szerkesztése')

@section('content')

    <h2 class="text-2xl">
        {{$post -> title}} szerkesztése</h2>

    <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        Cím: @error('title')
            {{ $message }}
        @enderror
        <br>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full"><br>
        Tartalom: @error('content')
            {{ $message }}
        @enderror
        <br>
        <textarea rows="5" name="content" class="w-full">{{ old('content', $post->content) }}</textarea><br>
        Publikus? <input type="checkbox" name="is_public" {{ old('is_public', $post->is_public) ? 'checked' : '' }}><br>
        @if ($post->image)
            <p>Jelenlegi kép:</p>
            <img src="{{ Storage::disk('public')->url('images/' . $post->image) }}" alt="" width="200">
        @endif
        <p>Új kép kiválasztása:</p>
        <input type="file" name="image_file" accept="image/jpeg,image/png,image/gif">
        @error('image_file')
            <p class="text-red-500">{{ $message }}</p>
        @enderror

        <h3 class="text-xl">Kategóriák</h3>
        @foreach ($categories as $category)
            <input type="checkbox" class="mr-2" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
            <span style="color: {{ $category->color }}">{{ $category->name }}</span><br>
        @endforeach

        <button class="mt-2 p-2 bg-sky-500 hover:bg-sky-400 rounded rounded-lg" type="submit">Mentés</button>
    </form>

@endsection
