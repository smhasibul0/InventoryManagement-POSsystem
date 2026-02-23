<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function AllSupplier() {
        $suppliers = Supplier::latest()->get();
        return view('admin.backend.supplier.all_supplier', compact('suppliers'));
    }

    public function AddSupplier() {
        return view('admin.backend.supplier.add_supplier');
    }

    public function StoreSupplier(Request $request) {
        Supplier::insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.supplier')->with($notification);
    }

    public function EditSupplier($id) {
        $supplier = Supplier::findOrFail($id);
        return view('admin.backend.supplier.edit_supplier', compact('supplier'));
    }

    public function UpdateSupplier(Request $request) {
        $supplier_id = $request->id;

        Supplier::findOrFail($supplier_id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.supplier')->with($notification);
    }

    public function DeleteSupplier($id) {
        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.supplier')->with($notification);
    }
}
