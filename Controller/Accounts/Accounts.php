<?php

namespace Controller\Accounts;

use Core\Controller;
use Core\Responses\JsonResponse;
use Core\Responses\PdfResponse;
use Model\Accounts as AccountsModel;
use Model\Transactions;

class Accounts extends Controller
{
    public function __construct()
    {
        $this->model = new AccountsModel();
    }

    /**
     * Usuwa konto usera
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(int $id): JsonResponse{
        $this->model->delete($id);
        return new JsonResponse([
            'status' => true
        ]);
    }

    /**
     * Zwraca aktualne saldo
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function getBalance(int $id): JsonResponse{
        $transactionModel = new Transactions();
        return new JsonResponse([
            'status' => true,
            'data' => $transactionModel->getBalance($id)
        ]);
    }

    /**
     * Drukuje zestawienie transakcji
     *
     * @param int $id
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return PdfResponse
     * @throws \Exception
     */
    public function printTransactions(int $id, string $dateFrom = null, string $dateTo = null): PdfResponse{
        $transactionModel = new Transactions();
        if (!$dateFrom) {
            $dateFrom = date("Y-m-d H:i:s", time() - 7*24*3600);
        }
        if (!$dateTo) {
            $dateTo = date("Y-m-d H:i:s");
        }
        $data = [
            'account' => $this->model->get($id),
            'transactions' => $transactionModel->getList($id, $dateFrom, $dateTo),
            'openBalance' => $transactionModel->getBalance($id, $dateFrom),
        ];
        return new PdfResponse('transactions', $data);
    }
}