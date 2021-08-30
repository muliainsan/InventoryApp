<?php

namespace App\Controllers;

use App\Models\IncomingMaterialModel;
use App\Models\WorkModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class IncomingMaterial extends BaseController
{
    protected $IncomingMaterialModel;
    protected $WorkModel;
    protected $title = 'Material Masuk';

    public function __construct()
    {
        // if (!session('email')) {
        //     header('Location: /Login');
        //     exit();
        // }
        $this->IncomingMaterialModel = new IncomingMaterialModel();
        $this->WorkModel = new WorkModel();
    }

    public function index()
    {

        $data = [
            'title' => $this->title,
            'IncomingMaterialData' => $this->IncomingMaterialModel->findAll(),
            'WorkModel' => $this->WorkModel,
        ];

        echo view('pages/IncomingMaterial/IncomingMaterialView', $data);
    }

    //function with view
    public function detail($id)
    {
        $data = $this->IncomingMaterialModel->getIncomingMaterial($id);
        var_dump($data);

        if (empty($data)) {
            throw new PageNotFoundException('IncomingMaterial with Id ' . $id . 'not found');
        };
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
            'IncomingMaterialData' => $this->IncomingMaterialModel->findAll(),
            'validation' => \Config\Services::validation(),
            'WorkData' => $this->WorkModel->findAll(),
        ];

        echo view('pages/IncomingMaterial/IncomingMaterialCreate', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => $this->title,
            'MaterialData' => $this->IncomingMaterialModel->getIncomingMaterial($id),
            'validation' => \Config\Services::validation(),
            'WorkData' => $this->WorkModel->findAll(),

        ];

        return view('pages/IncomingMaterial/IncomingMaterialEdit', $data);
    }


    //function  CRUD
    public function save()
    {
        //validation
        $MaterialName = $this->request->getVar('inputMaterialname');
        $Work = $this->request->getVar('inputWork');
        $EvidenceFile = $this->request->getFile('inputEvidence');



        $validation = $this->_validationSave();
        if (!is_null($validation)) {
            return $validation;
        }

        $Evidence = $EvidenceFile->getRandomName();
        $EvidenceFile->move('img', $Evidence);

        $saveResult = $this->IncomingMaterialModel->save([
            "MaterialName" => $MaterialName,
            "WorkId" => $Work,
            "Evidence" => $Evidence,
            "_CreatedBy" => session("email")
        ]);

        if (!$saveResult) {
            session()->setFlashdata('pesan', 'Failed');
        } else {
            session()->setFlashdata('pesan', 'Data added successfully.');
        }
        return redirect()->to('/IncomingMaterial')->withInput();
    }


    public function delete()
    {
        $id = $this->request->getVar('Id');
        $temp = $this->IncomingMaterialModel->find($id);
        unlink('img/' . $temp['Evidence']);

        $this->IncomingMaterialModel->delete($id);
        session()->setFlashdata('pesan', 'Data Deleted successfully.');
        return redirect()->to('/IncomingMaterial');
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $MaterialName = $this->request->getVar('inputMaterialname');
        $Work = $this->request->getVar('inputWork');
        $EvidenceFile = $this->request->getFile('inputEvidence');
        $OldEvidence = $this->request->getVar('oldEvidence');

        if ($EvidenceFile->getError() == 4) {
            $EvidenceName = $OldEvidence;
        } else {
            $EvidenceName = $EvidenceFile->getRandomName();
            $EvidenceFile->move('img', $EvidenceName);
            unlink('img/' . $OldEvidence);
        }

        //validation
        $validation =

            $this->_validationEdit(
                $this->request->getVar('inputMaterialname'),
                $this->IncomingMaterialModel->getIncomingMaterial($id)

            );

        if (!is_null($validation)) {

            return $validation;
        }

        //Update function is same as Save
        $this->IncomingMaterialModel->save([
            "Id" => $id,
            "MaterialName" => $MaterialName,
            "WorkId" => $Work,
            "Evidence" => $EvidenceName,
        ]);

        session()->setFlashdata('pesan', 'Data updated successfully.');

        return redirect()->to('/IncomingMaterial')->withInput();
    }

    public function updateStatus()
    {

        $id = $this->request->getVar('Id');
        $status = $this->request->getVar('Status');

        $this->IncomingMaterialModel->save([
            "Id" => $id,
            "Status" => $status
        ]);
        session()->setFlashdata('pesan', 'Data Updated successfully.');
        return redirect()->to('/IncomingMaterial');
    }



    public function _validationSave()
    {
        $rules = 'required';

        $validate = [
            'inputMaterialname' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Material Name" can not be empty',
                    'is_unique' => '"Material Name" has been registered'
                ]
            ],
            'inputWork' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Work" can not be empty',
                    'is_unique' => '"Work" has been registered'
                ]
            ],
            'inputEvidence' => 'uploaded[inputEvidence]'


        ];

        if (!$this->validate($validate)) {
            return redirect()->to('/IncomingMaterial/Create')->withInput();
        }
    }

    public function _validationEdit($IncomingMaterialName, $IncomingMaterialDataOld)
    {
        $rules = 'required';



        $validate = [

            'inputMaterialname' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Material Name" can not be empty',
                    'is_unique' => '"Material Name" has been registered'
                ]
            ],
            'inputWork' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Work" can not be empty',
                    'is_unique' => '"Work" has been registered'
                ]
            ],

        ];

        if (!$this->validate($validate)) {
            var_dump($validate);

            return redirect()->to('/IncomingMaterial/Edit/' . $IncomingMaterialDataOld['Id'])->withInput();
        }
    }
}
