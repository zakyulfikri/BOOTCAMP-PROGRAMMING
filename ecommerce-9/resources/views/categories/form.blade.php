@if ($errors->any())<div class="mb-4 rounded bg-red-100 p-3 text-black"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ $action }}" method="POST" class="space-y-4">@csrf @if ($method !== 'POST') @method($method) @endif
    <div><label for="name" class="mb-1 block font-medium">Nama Kategori</label><input id="name" name="name" value="{{ old('name', $category?->name) }}" required class="w-full rounded border-gray-300"></div>
    <div><label for="slug" class="mb-1 block font-medium">Slug</label><input id="slug" name="slug" value="{{ old('slug', $category?->slug) }}" required class="w-full rounded border-gray-300"></div>
    <div class="flex gap-3"><button class="rounded bg-red-600 px-4 py-2 font-semibold text-black hover:bg-red-700">Simpan</button><a href="{{ route('categories.index') }}" class="rounded border border-gray-300 px-4 py-2 text-black">Batal</a></div>
</form>