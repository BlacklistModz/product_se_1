<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreModel as SM;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    protected $cValidator = [
        'name' => 'required|min:3|max:255',
        'address' => 'required|min:10'
    ];

    protected $cValidatorMsg = [
        'name.required' => 'กรุณากรอกชื่อร้านค้า',
        'name.min' => 'ชื่อร้านค้าต้องมีอย่างน้อย 3 ตัวอักษร',
        'name.max' => 'ชื่อร้านค้าต้องมีไม่เกิน 255 ตัวอักษร',
        'detail.required' => 'กรุณากรอกที่อยู่ร้านค้า',
        'detail.min' => 'รายละเอียดร้านค้าต้องมีอย่างน้อย 10 ตัวอักษร'
    ];

    private $limit = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function index( Request $request, SM $db )
    {
        $request->limit = !empty($request->limit) ? $request->limit : $this->limit;
        $data = $db->lists( $request );
        return view('store.display')->with(['data'=>$data, 'limit'=>$request->limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store.forms.formStore');
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
            $data = new SM;
            $data->fill( Input::all() );
            if( $data->save() ){
                if( $request->has('logo') ){
                    $data->logo = $request->file('logo')->store('store','public');
                    $data->update();
                }
            }
            return redirect()
                    ->route('store.index')
                    ->with('jsAlert', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
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
        $data = SM::findOrFail( $id );
        if( is_null($data) ){
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
        }
        return view('store.forms.formStore')->with('data', $data);
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
        $data = SM::findOrFail( $id );
        if( is_null($data) ){
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
            if( $data->update() ){
                if( $request->has('logo') ){
                    if( !empty($data->logo) ){
                        Storage::disk('public')->delete($data->logo);
                    }
                    $data->logo = $request->file('logo')->store('store', 'public');
                    $data->update();
                }
            }
            return redirect()
                    ->route('store.index')
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
        $data = SM::findOrFail( $id );
        if( is_null($data) ){
            return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
        }

        if( !empty($data->logo) ){
            Storage::disk('public')->delete($data->logo);
        }
        return back()->with('jsAlert', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
