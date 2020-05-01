<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel AS PM; //เรียก ProductModel มาใช้ใน Controller นี้
use App\Models\ProductTypeModel AS PTM; //เรียก ProductTypeModel 
use App\Models\StoreModel AS SM;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $cValidator = [
        'store' => 'required',
        'type' => 'required',
        'name' => 'required|min:3|max:255',
        'detail' => 'required|min:10',
        'price' => 'required|numeric|digits_between:1,9'
    ];

    protected $cValidatorMsg = [
        'store.required' => 'กรุณาเลือกร้านค้า',
        'type.required' => 'กรุณาเลือกประเภทสินค้า',
        'name.required' => 'กรุณากรอกชื่อสินค้า',
        'name.min' => 'ชื่อสินค้าต้องมีอย่างน้อย 3 ตัวอักษร',
        'name.max' => 'ชื่อสินค้าต้องมีไม่เกิน 255 ตัวอักษร',
        'detail.required' => 'กรุณากรอกรายละเอียด',
        'detail.min' => 'รายละเอียดสินค้าต้องมีอย่างน้อย 10 ตัวอักษร',
        'price.required' => 'กรุณากรอกราคาสินค้า',
        'price.numeric' => 'ราคาสินค้าต้องเป็นตัวเลข 0-9 เท่านั้น',
        'price.digits_between' => 'ราคาสินค้าสามารถกรอกได้ตั้งแต่ 1 ตัวเลขขึ้นไป แต่ไม่เกิน 9 ตัวเลข' 
    ];

    private $limit = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PM $pm)
    {
        $request->limit = !empty($request->limit) ? $request->limit : $this->limit;
        $data = $pm->lists( $request );
        // dd($data);
        return view('product.product')->with( ["data"=>$data, "limit"=>$request->limit, "type"=>PTM::get(), "store"=>SM::get()] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.forms.formProduct')->with( ['type'=>PTM::get(), "store"=>SM::get()] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg );
        if( $validator->fails() ){
            return back()
                    ->withInput()
                    ->withErrors( $validator->errors() );
        }
        else{
            $data = new PM;
            $data->fill( Input::all() );
            if( $data->save() ){
                if( $request->has('image') ){
                    $data->image = $request->file('image')->store('photos','public');
                    $data->update();
                }
            }
            return redirect()
                    ->route('product.index')
                    ->with( "jsAlert", "บันทึกข้อมูลเรียบร้อยแล้ว" );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PM::findOrFail( $id );
        if( is_null($data) ){
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
        }
        return view('product.forms.formProduct')->with( [ 'data'=>$data, 'type'=>PTM::get(), "store"=>SM::get() ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = PM::findOrFail($id);
        if (is_null($data)) {
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
        }
            
        $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg );
        if( $validator->fails() ){
            return back()
                    ->withInput()
                    ->withErrors( $validator->errors() );
        }
        else{
            $data->fill( Input::all() );
            if ($data->update()) {
                if ($request->has('image')) {
                    //DELETE OLD IMAGE
                    if (!empty($data->image)) {
                        Storage::disk('public')->delete($data->image);
                    }
                     //UPLOAD NEW IMAGE
                    $data->image = $request->file('image')->store('photos', 'public');
                    $data->update();
                }
            }
            return redirect()
                    ->route('product.index')
                    ->with("jsAlert", "แก้ไขข้อมูลเรียบร้อยแล้ว");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function delete($id){
        $data = PM::findOrFail($id);
        if( is_null($data) ){
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการลบ");
        }
        if( !empty($data->image) ){
            Storage::disk('public')->delete( $data->image );
        }
        $data->delete();
        return back()->with('jsAlert', "ลบข้อมูลเรียบร้อยแล้ว");
    }
}