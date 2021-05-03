<?php

namespace App\Logic\Maintenance;

class Maintenance
{
    private $model;
    private $errors = [];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validate($params)
    {
        $errors = $this->model->validate($params);

        if (!empty($errors)) {
            $this->errors = $errors;
        }
    }

    public function parseForm($params)
    {
        return $this->model->parseForm($params);
    }

    public function create($params)
    {
        return $this->model->create($params);
    }

    public function update($params)
    {
        return $this->model->update($params);
    }

    public function get($id)
    {
        $this->model = $this->model->find($id);
    }

    public function delete()
    {
        if (isset($this->model->id)) {
            if (method_exists($this->model, 'preDelete')) {
                $this->model->preDelete();
            }

            return $this->model->delete();
        }

        $this->errors[] = ['No existe un registro con ese identificador'];
    }

    public function Query($filter = [])
    {
        return $this->model->getQuery($filter);
    }

    public function returnModel()
    {
        return $this->model;
    }
}
