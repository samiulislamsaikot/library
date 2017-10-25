<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Admin\MedicineRequest;
use App\Models\Admin\GenericName;
use App\Models\Admin\Indication;
use App\Models\Admin\Medicine;
use App\Models\Admin\MedicineType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicinesController extends Controller
{
    public function __construct()
    {
        $this->module_name  = 'medicine';
        $this->module_title = 'Medicine';
        $this->module_path  = 'medicines';
        $this->module_icon  = 'fa fa-medkit';
        $this->module_model = 'App\Models\Admin\Medicine';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('List of the Medicine Name');
        $data['module_name']    = $this->module_name;
        $data['module_title']   = $this->module_title;
        $data['module_path']    = $this->module_path;
        $data['module_icon']    = $this->module_icon;
        $data['module_model']   = $this->module_model;
        $data['module_action']  = "list";

        $data['page_heading']   = ucfirst($data['module_name']);
        $data['title']          = ucfirst($data['module_name']) . ' ' . ucfirst($data['module_action']);

        $data['medicines'] = Medicine::all();

        return view("backend.admin.medicines.medicines.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        dd('Call Create of the Generic Name');
        $data['module_name']    = $this->module_name;
        $data['module_title']   = $this->module_title;
        $data['module_path']    = $this->module_path;
        $data['module_icon']    = $this->module_icon;
        $data['module_model']   = $this->module_model;
        $data['module_action']  = "create";

        $data['page_heading']   = ucfirst($data['module_name']);
        $data['title']          = ucfirst($data['module_name']) . ' ' . ucfirst($data['module_action']);

        $data['medicine_types']     = MedicineType::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();
        $data['generic_names']      = GenericName::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();
        $data['indications']        = Indication::where('status', true)->orderBy('id')->pluck('key_word', 'id')->toArray();
//        $data['pharmaceuticals']    = Pharmaceutical::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();

        $pharmaceuticals = [
            'Square Pharmaceuticals Ltd',
            'Beximco Pharmaceuticals Ltd',
            'Incepta Pharmaceutical Ltd',
            'Renata Limited',
            'ACI Limited',
            'ACME Laboratories Ltd',
            'Aristopharma Ltd',
            'General Pharmaceutical Ltd',
            'Globe Pharmaceuticals Ltd',
            'Healthcare Pharmaceuticals Limited',
            'Bio-Pharma Laboratories Ltd',
            'Opsonin Pharma Ltd',
            'Silva Pharmaceuticals Ltd',
            'Jayson Pharmaceuticals Ltd',
            'Drug International Limited',
            'Beacon Pharmaceuticals',
            'Gaco Pharmaceuticals',
            'Eskayef Bangladesh Ltd',
            'GlaxoSmithKline Bangladesh Limited',
            'Nuvista Pharma Ltd',
            'Zuellig Pharma Bangladesh Ltd',
            'Novo Nordisk A/S',
            'Novartis (Bangladesh) Ltd',
        ];

        $data['pharmaceuticals']    = $pharmaceuticals;

        $medicine_classes = [
            'ABCDEFGH001' => 'ABCDEFGH001',
            'ABCDEFGH002' => 'ABCDEFGH002',
            'ABCDEFGH003' => 'ABCDEFGH003',
            'ABCDEFGH004' => 'ABCDEFGH004',
            'ABCDEFGH005' => 'ABCDEFGH005',
            'ABCDEFGH006' => 'ABCDEFGH006',
            'ABCDEFGH007' => 'ABCDEFGH007',
            'ABCDEFGH008' => 'ABCDEFGH008',
            'ABCDEFGH009' => 'ABCDEFGH009',
            'ABCDEFGH010' => 'ABCDEFGH010',
            'ABCDEFGH011' => 'ABCDEFGH011',
            'ABCDEFGH012' => 'ABCDEFGH012',
            'ABCDEFGH013' => 'ABCDEFGH013',
            'ABCDEFGH014' => 'ABCDEFGH014',
            'ABCDEFGH015' => 'ABCDEFGH015',
            'ABCDEFGH016' => 'ABCDEFGH016',
            'ABCDEFGH017' => 'ABCDEFGH017',
            'ABCDEFGH018' => 'ABCDEFGH018',
            'ABCDEFGH019' => 'ABCDEFGH019',
            'ABCDEFGH020' => 'ABCDEFGH020',

        ];

        $data['medicine_classes'] = $medicine_classes;

//        dd($data);

        return view("backend.admin.medicines.medicines.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicineRequest $request)
    {
//        dd($request->all());
        $medicineNameExist = $this->checkMedicineName($request->input('name'));
//        $medicineCodeExist = $this->checkMedicineCode($request->input('code'));

        if($medicineNameExist) {
            return redirect()->back()->with('flash_danger', 'Your Given Medicine Already Exists. Please Insert a Different Medicine Name.')->withInput($request->all);
        }
//        if($medicineCodeExist) {
//            return redirect()->back()->with('flash_danger', 'Your Given Code of Medicine Already Exists. Please Insert a Different Code for Medicine.')->withInput($request->all);
//        }

        $medicineData = $request->except('_token', 'pharmaceuticals_id', 'medicine_class_id');

        $medicineTypeID = $request->input('medicine_type_id');
        $medicineTypeName = MedicineType::where('id', $medicineTypeID)->value('name');

        $genericNameID = $request->input('generic_name_id');
        $genericName = GenericName::where('id', $genericNameID)->value('name');

        $indicationID = $request->input('indications_id');
        $indicationKeyWord = Indication::where('id', $indicationID)->value('key_word');

//        $pharmaceuticalsID = $request->input('pharmaceuticals_id');
//        $pharmaName = Pharmaceuticals::where('id', $pharmaceuticalsID)->pluck('name');

//        $classID = $request->input('class_id');
//        $className = Pharmaceuticals::where('id', $classID)->pluck('name');

        $medicineData['medicine_type_name']     = $medicineTypeName;
        $medicineData['generic_name']           = $genericName;
        $medicineData['indications_key_words']  = $indicationKeyWord;
//        $medicineData['pharma_name']            = $pharmaName;
//        $medicineData['class_name']             = $className;

        $medicineData['code'] = $this->randomNumber(6);

        $medicine = Medicine::create($medicineData);
        $message = 'Your Medicine has been Created/Added Successfully';

        return redirect()->route("admin.medicine.index")->with('flash_success', '<i class="fa fa-check"></i> ' . $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd('Details of the Medicine');
        $data['module_name']    = $this->module_name;
        $data['module_title']   = $this->module_title;
        $data['module_path']    = $this->module_path;
        $data['module_icon']    = $this->module_icon;
        $data['module_model']   = $this->module_model;
        $data['module_action']  = "details";

        $data['page_heading']   = ucfirst($data['module_name']);
        $data['title']          = ucfirst($data['module_name']) . ' ' . ucfirst($data['module_action']);

        $data['medicine']  = Medicine::findOrFail($id);

        return view("backend.admin.medicines.medicines.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd('Call Edit Page of the Medicine');
        $data['module_name']    = $this->module_name;
        $data['module_title']   = $this->module_title;
        $data['module_path']    = $this->module_path;
        $data['module_icon']    = $this->module_icon;
        $data['module_model']   = $this->module_model;
        $data['module_action']  = "edit/update";

        $data['page_heading']   = ucfirst($data['module_name']);
        $data['title']          = ucfirst($data['module_name']) . ' ' . ucfirst($data['module_action']);

        $data['medicine']  = Medicine::findOrFail($id);

        $data['medicine_types']     = MedicineType::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();
        $data['generic_names']      = GenericName::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();
        $data['indications']        = Indication::where('status', true)->orderBy('id')->pluck('key_word', 'id')->toArray();
//        $data['pharmaceuticals']    = Pharmaceutical::where('status', true)->orderBy('id')->pluck('name', 'id')->toArray();

        $pharmaceuticals = [
            'Square Pharmaceuticals Ltd',
            'Beximco Pharmaceuticals Ltd',
            'Incepta Pharmaceutical Ltd',
            'Renata Limited',
            'ACI Limited',
            'ACME Laboratories Ltd',
            'Aristopharma Ltd',
            'General Pharmaceutical Ltd',
            'Globe Pharmaceuticals Ltd',
            'Healthcare Pharmaceuticals Limited',
            'Bio-Pharma Laboratories Ltd',
            'Opsonin Pharma Ltd',
            'Silva Pharmaceuticals Ltd',
            'Jayson Pharmaceuticals Ltd',
            'Drug International Limited',
            'Beacon Pharmaceuticals',
            'Gaco Pharmaceuticals',
            'Eskayef Bangladesh Ltd',
            'GlaxoSmithKline Bangladesh Limited',
            'Nuvista Pharma Ltd',
            'Zuellig Pharma Bangladesh Ltd',
            'Novo Nordisk A/S',
            'Novartis (Bangladesh) Ltd',
        ];

        $data['pharmaceuticals']    = $pharmaceuticals;

        $medicine_classes = [
            'ABCDEFGH001' => 'ABCDEFGH001',
            'ABCDEFGH002' => 'ABCDEFGH002',
            'ABCDEFGH003' => 'ABCDEFGH003',
            'ABCDEFGH004' => 'ABCDEFGH004',
            'ABCDEFGH005' => 'ABCDEFGH005',
            'ABCDEFGH006' => 'ABCDEFGH006',
            'ABCDEFGH007' => 'ABCDEFGH007',
            'ABCDEFGH008' => 'ABCDEFGH008',
            'ABCDEFGH009' => 'ABCDEFGH009',
            'ABCDEFGH010' => 'ABCDEFGH010',
            'ABCDEFGH011' => 'ABCDEFGH011',
            'ABCDEFGH012' => 'ABCDEFGH012',
            'ABCDEFGH013' => 'ABCDEFGH013',
            'ABCDEFGH014' => 'ABCDEFGH014',
            'ABCDEFGH015' => 'ABCDEFGH015',
            'ABCDEFGH016' => 'ABCDEFGH016',
            'ABCDEFGH017' => 'ABCDEFGH017',
            'ABCDEFGH018' => 'ABCDEFGH018',
            'ABCDEFGH019' => 'ABCDEFGH019',
            'ABCDEFGH020' => 'ABCDEFGH020',

        ];

        $data['medicine_classes'] = $medicine_classes;

//        dd($data);

        return view("backend.admin.medicines.medicines.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicineRequest $request, $id)
    {
        $medicineNameExist = $this->checkMedicineForUpdate($request->input('name'), $id);
//        $medicineCodeExist = $this->checkMedicineCodeForUpdate($request->input('code'), $id);

        if($medicineNameExist) {
            return redirect()->back()->with('flash_danger', 'Your Given Medicine Name Already Exists. Please Insert a Different Medicine Name.')->withInput($request->all);
        }
//        if($medicineCodeExist) {
//            return redirect()->back()->with('flash_danger', 'Your Given Code of Medicine Already Exists. Please Insert a Different Code for Medicine.')->withInput($request->all);
//        }

        $medicineTypeID = $request->input('medicine_type_id');
        $medicineTypeName = MedicineType::where('id', $medicineTypeID)->value('name');

        $genericNameID = $request->input('generic_name_id');
        $genericName = GenericName::where('id', $genericNameID)->value('name');

        $indicationID = $request->input('indications_id');
        $indicationKeyWord = Indication::where('id', $indicationID)->value('key_word');

//        $pharmaceuticalsID = $request->input('pharmaceuticals_id');
//        $pharmaName = Pharmaceuticals::where('id', $pharmaceuticalsID)->pluck('name');

//        $classID = $request->input('class_id');
//        $className = Pharmaceuticals::where('id', $classID)->pluck('name');

        $medicineData['medicine_type_name']     = $medicineTypeName;
        $medicineData['generic_name']           = $genericName;
        $medicineData['indications_key_words']  = $indicationKeyWord;
//        $medicineData['pharma_name']            = $pharmaName;
//        $medicineData['class_name']             = $className;


        $medicine = Medicine::findOrFail($id);
        $medicineData = $request->except('_token', 'pharmaceuticals_id', 'medicine_class_id');
        $medicine->fill($medicineData)->save();

        $message = 'Your Selected Medicine has been Updated Successfully';

        return redirect()->route("admin.medicine.index")->with('flash_success', '<i class="fa fa-check"></i> ' . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd('Call Destroy Method of the Medicine');
        $record = Medicine::find($id);
        $record->destroy($id);

        return;
    }

    /**
     * Display a listing of the trash resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trash()
    {
        $data['module_name']    = $this->module_name;
        $data['module_title']   = $this->module_title;
        $data['module_path']    = $this->module_path;
        $data['module_icon']    = $this->module_icon;
        $data['module_model']   = $this->module_model;
        $data['module_action']  = "Trash list";

        $data['page_heading']   = ucfirst($data['module_name']);
        $data['title']          = ucfirst($data['module_name']) . ' ' . ucfirst($data['module_action']);

        $data['medicines'] = Medicine::onlyTrashed()->orderBy('id', 'asc')->get();

        return view("backend.admin.medicines.medicines.trash", $data);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $record = Medicine::withTrashed()->find($id);
        $record->restore();

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permanentlyDelete($id)
    {
        $record = Medicine::withTrashed()->find($id);
        $record->forceDelete($id);

        return;
    }

    public function checkMedicineName($medicineName){

        $result = Medicine::where('name', $medicineName)->first();
        return $result;
    }

    public function checkMedicineCode($medicineCode){

        $result = Medicine::where('code', $medicineCode)->first();
        return $result;
    }

    public function checkMedicineForUpdate($medicineName, $id){

        $result = Medicine::where('name', $medicineName)->where('id', '!=', $id)->first();
        return $result;
    }

    public function checkMedicineCodeForUpdate($medicineCode, $id){

        $result = Medicine::where('code', $medicineCode)->where('id', '!=', $id)->first();
        return $result;
    }

    public function randomNumber($length) {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

}
