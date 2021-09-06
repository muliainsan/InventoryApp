<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\WorkModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Material extends BaseController
{
    protected $MaterialModel;
    protected $WorkModel;
    protected $title = 'Material';

    public function __construct()
    {
        if (!session('user')) {
            header('Location: /Login');
            exit();
        }
        $this->MaterialModel = new MaterialModel();
        $this->WorkModel = new WorkModel();
    }

    public function index()
    {

        $data = [
            'title' => $this->title,
            'MaterialData' => $this->MaterialModel->findAll(),
            'WorkModel' => $this->WorkModel,
        ];

        echo view('pages/Material/MaterialView', $data);
    }

    //function with view
    public function detail($id)
    {
        $data = $this->MaterialModel->getMaterial($id);
        var_dump($data);

        if (empty($data)) {
            throw new PageNotFoundException('Material with Id ' . $id . 'not found');
        };
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
            'MaterialData' => $this->MaterialModel->findAll(),
            'WorkData' => $this->WorkModel->findAll(),
            'validation' => \Config\Services::validation()

        ];

        echo view('pages/Material/MaterialCreate', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => $this->title,
            'MaterialData' => $this->MaterialModel->getMaterial($id),
            'WorkData' => $this->WorkModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('pages/Material/MaterialEdit', $data);
    }


    //function  CRUD
    public function save()
    {

        $MaterialName = $this->request->getVar('inputMaterial');
        $Price = $this->request->getVar('inputPrice');
        $Workid = $this->request->getVar('inputWork') == 'No Work' ? NULL : $this->request->getVar('inputWork');

        //validation
        $validation = $this->_validationSave($MaterialName);
        if (!is_null($validation)) {
            return $validation;
        }

        $this->MaterialModel->save([
            'MaterialName' => $MaterialName,
            'Price' => $Price,
            'WorkId' => $Workid,
        ]);

        session()->setFlashdata('pesan', 'Data added successfully.');

        return redirect()->to('/Material')->withInput();
    }


    public function delete()
    {
        $id = $this->request->getVar('Id');
        $this->MaterialModel->delete($id);
        session()->setFlashdata('pesan', 'Data Deleted successfully.');
        return redirect()->to('/Material');
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $MaterialName = $this->request->getVar('inputMaterial');
        $Price = $this->request->getVar('inputPrice');
        $Workid = $this->request->getVar('inputWork') == 'No Work' ? NULL : $this->request->getVar('inputWork');

        //validation
        $validation =

            $this->_validationEdit(
                $this->request->getVar('inputMaterial'),
                $this->MaterialModel->getMaterial($id)

            );
        if (!is_null($validation)) {
            return $validation;
        }

        //Update function is same as Save
        $this->MaterialModel->save([
            'Id' => $id,
            'MaterialName' => $MaterialName,
            'Price' => $Price,
            'WorkId' => $Workid,
        ]);

        session()->setFlashdata('pesan', 'Data updated successfully.');

        return redirect()->to('/Material')->withInput();
    }



    public function _validationSave($MaterialName)
    {
        $rules = 'required|is_unique[Material.MaterialName]';
        if ($this->MaterialModel->is_unique($MaterialName)) {

            $rules = 'required';
        }

        $validate = [
            'inputMaterial' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Material Name" can not be empty',
                    'is_unique' => '"Material Name" has been registered'
                ]
            ],
            'inputPrice' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '"Price" can not be empty',
                ]
            ]
        ];

        if (!$this->validate($validate)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/Material/Create')->withInput()->with('validation', $validation);
        }
    }

    public function _validationEdit($MaterialName, $MaterialDataOld)
    {
        $rules = 'required|is_unique[Material.MaterialName]';

        if ($MaterialName == $MaterialDataOld['MaterialName'] || $this->MaterialModel->is_unique($MaterialName)) {

            $rules = 'required';
        }

        $validate = [
            'inputMaterial' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '"Material Name" can not be empty',
                    'is_unique' => '"Material Name" has been registered'
                ]
            ],
            'inputPrice' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '"Price" can not be empty',
                ]
            ]
        ];

        if (!$this->validate($validate)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/Material/Edit/' . $MaterialDataOld['Id'])->withInput()->with('validation', $validation);
        }
    }
}
