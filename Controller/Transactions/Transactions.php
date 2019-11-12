<?php

namespace Controller\Transactions;

use Core\Controller;
use Model\Transactions as TransactionsModel;

class Transactions extends Controller
{
    public function __construct()
    {
        $this->model = new TransactionsModel();
    }
}