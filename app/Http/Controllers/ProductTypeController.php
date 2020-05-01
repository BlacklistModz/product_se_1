<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTypeModel AS PTM; //เรียก ProductModel มาใช้ใน Controller นี้
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductTypeController extends Controller
{
    protected $cValidator = [
        'name' => 'required|min:3|max:255'
    ];

    protected $cValidatorMsg = [
        'name.required' => 'กรุณากรอกชื่อประเภทสินค้า',
        'name.min' => 'ชื่อสินค้าต้องมีอย่างน้อย 3 ตัวอักษร',
        'name.max' => 'ชื่อสินค้าต้องมีไม่เกิน 255 ตัวอักษร'
    ];

    private $limit = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PTM $ptm)
    {
        $request->limit = !empty($request->limit) ? $request->limit : $this->limit;
        $data = $ptm->lists( $request );
        // dd($data);
        return view('producttype')->with( ["data"=>$data, "limit"=>$request->limit] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.formProductType');
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
            $data = new PTM;
            $data->fill( Input::all() )->save();
            return redirect()
                    ->route('producttype.index')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PTM::findOrFail($id);
        if( is_null($data) ){
            return back()
                    ->with('jsAlert', 'ไม่สามารถค้นหาข้อมูลที่ต้องการแก้ไขได้');
        }
        return view('forms.formProductType')->with('data', $data);
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
        $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg );
        if( $validator->fails() ){
            return back()
                    ->withInput()
                    ->withErrors( $validator->errors() );
        }
        else{
            $data = PTM::findOrFail($id);
            if (is_null($data)) {
                return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
            }
            $data->fill( Input::all() )->update();
            return redirect()
                    ->route('producttype.index')
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
        //
    }

    public function delete($id){
        $data = PTM::findOrFail($id);
        if( is_null($data) ){
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการลบ");
        }
        $data->delete();
        return back()->with('jsAlert', "ลบข้อมูลเรียบร้อยแล้ว");
    }
}
