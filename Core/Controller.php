<?php

namespace Core;

use Core\Responses\JsonResponse;

abstract class Controller
{
    protected $db;
    protected $model;

    public function __construct()
    {
        global $_DB;
        $this->db = $_DB;
    }

    /**
     * Pobiera dane z modelu
     *
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse{
        return new JsonResponse([
            'status' => true,
            'data' => $this->model->get($id),
        ]);
    }

    /**
     * Zapisuje dane do modelu
     *
     * @param $data
     * @return JsonResponse
     */
    public function save($data): JsonResponse{
        $saved = $this->model->save($data);
        return new JsonResponse([
            'status' => true,
            'data' => $saved
        ]);
    }
}