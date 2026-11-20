<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->string('search') . '%');
            })
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', ['category' => new Category]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request);
        }

        Category::query()->create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validatedData($request, $category);
        $oldImage = $category->image;

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request);
        } else {
            unset($data['image']);
        }

        $category->update($data);

        if ($oldImage !== $category->image) {
            $this->deleteImage($oldImage);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->withErrors([
                'category' => 'Kategori ini masih digunakan oleh produk sehingga tidak dapat dihapus.',
            ]);
        }

        $image = $category->image;
        $category->delete();
        $this->deleteImage($image);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $slug = $request->input('slug');
        $name = $request->input('name');

        $request->merge([
            'slug' => Str::slug(
                is_string($slug) && $slug !== ''
                    ? $slug
                    : (is_string($name) ? $name : '')
            ),
        ]);

        $uniqueSlug = Rule::unique('categories', 'slug');
        if ($category) {
            $uniqueSlug->ignore($category);
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $uniqueSlug],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function storeImage(Request $request): string
    {
        $path = $request->file('image')->storePublicly('categories', 'public');

        if (! is_string($path)) {
            throw new RuntimeException('Gambar kategori gagal disimpan.');
        }

        return $path;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path) && ! Storage::disk('public')->delete($path)) {
            throw new RuntimeException('Gambar kategori lama gagal dihapus.');
        }
    }
}
