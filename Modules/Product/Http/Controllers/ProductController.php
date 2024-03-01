<?php

namespace Modules\Product\Http\Controllers;

use Modules\Product\DataTables\ProductDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Upload\Entities\Upload;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('product::products.index');
    }


    public function create()
    {
        abort_if(Gate::denies('create_products'), 403);

        return view('product::products.create');
    }


    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Produk Ditambahkan!', 'success');

        return redirect()->route('products.index');
    }


    public function show(Product $product)
    {
        abort_if(Gate::denies('show_products'), 403);

        return view('product::products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        abort_if(Gate::denies('edit_products'), 403);

        return view('product::products.edit', compact('product'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->except('document'));

        if ($request->has('document')) {
            // Hapus gambar lama
            foreach ($product->getMedia('images') as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    Storage::delete($media->getPath());
                    $media->delete();
                }
            }

            // Tambah gambar baru
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Produk Diperbarui!', 'info');

        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        abort_if(Gate::denies('delete_products'), 403);

        // Hapus file-file gambar terkait dari direktori lokal
        foreach ($product->getMedia('images') as $media) {
            // Hapus file gambar
            Storage::delete($media->getPath());
            // Hapus entri media dari produk
            $media->delete();
        }

        // Hapus produk dari database
        $product->delete();


        toast('Produk Dihapus!', 'warning');

        return redirect()->route('products.index');
    }
}
