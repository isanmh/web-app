<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductApiController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10);
        return response()->json($products, Response::HTTP_OK);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data produk berhasil ditemukan',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        // validasi request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|',
            'image' => 'image|required|max:2048|mimes:png,jpg,jpeg'
        ]);

        $input = $request->all();

        // logika upload gambar
        if ($image = $request->file('image')) {
            $target = 'assets/images/';
            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($target, $product_img);
            $input['image'] = $product_img;
        }

        // masukan data ke database
        Product::create($input);

        $data = [
            'status' => Response::HTTP_CREATED,
            'message' => 'Data produk berhasil ditambahkan',
            'data' => $input
        ];
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            // validasi request
            $request->validate([
                'name' => 'string|max:255',
                'price' => 'integer',
                'description' => 'string|',
                // 'image' => 'image|max:2048|mimes:png,jpg,jpeg'
            ]);

            $input = $request->all();

            // logika upload gambar
            if ($image = $request->file('image')) {
                $target = 'assets/images/';
                // jika ada image
                unlink($target . $product->image);
                $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($target, $product_img);
                $input['image'] = $product_img;
            } else {
                // jika tidak ada image
                $input['image'] = $product->image;
            }

            // update data ke database
            $product->update($input);

            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data produk berhasil diupdate',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }

    // delete product
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $target = 'assets/images/';
            unlink($target . $product->image);
            $product->delete();

            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data produk berhasil dihapus',
            ];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }
}
