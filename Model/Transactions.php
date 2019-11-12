<?php

namespace Model;

use Core\Model;

class Transactions extends Model
{
    /**
     * Pobiera szczegóły transakcji
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array{
        return $this->db->getRow("SELECT * FROM transactions WHERE id = ?", $id);
    }

    /**
     * Dodawnie/edycja transakcji
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function save($data): array{
        $this->validate($data);
        if (!array_key_exists('id',$data)) {
            $rs = $this->db->execute("SELECT * FROM transactions WHERE 1=0");
            $sql = $this->db->getInsertSQL($rs,$data);
        } else {
            $rs = $this->db->execute("SELECT * FROM transactions WHERE id = ?", (int)$data['id']);
            $sql = $this->db->getUpdateSQL($rs,$data);
        }
        if (!$this->db->query($sql)) {
            throw new \Exception($this->db->errorMsg());
        }
        return $this->get($data['id'] ?? $this->db->Insert_ID());
    }

    /**
     * Walidacja danych wejściowych
     *
     * @param array $data
     * @throws \Exception
     */
    private function validate(array &$data):void {
        if (!array_key_exists('id', $data)) {
            if (!$data['title']) {
                throw new \Exception("title field is require!");
            }
            if (!$data['amount']) {
                throw new \Exception("amount field is require!");
            }
            if (!$data['to_user']) {
                throw new \Exception("to_user field is require!");
            }
            if (!$data['currency']) {
                throw new \Exception("currency field is require!");
            }
        }
        if (array_key_exists('added', $data)) {
            unset($data['added']);
        }
    }

    /**
     * Pobieranie listy transakcji
     *
     * @param int $id
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     * @throws \Exception
     */
    public function getList(int $id, string $dateFrom, string $dateTo): array{
        if(date("Y-m-d H:i:s", strtotime($dateFrom)) != $dateFrom){
            throw new \Exception("Wrong dateFrom format!");
        }
        if(date("Y-m-d H:i:s", strtotime($dateTo)) != $dateTo){
            throw new \Exception("Wrong dateTo format!");
        }
        return $this->db->getAssoc("SELECT * FROM transactions WHERE ? IN(from_user,to_user) AND deleted IS NULL AND added >= ? AND added <= ?", [
            $id,
            $dateFrom,
            $dateTo,
        ]);
    }

    /**
     * Pobieranie salda na daną datę
     *
     * @param int $id
     * @param string|null $dateTo
     * @return string
     * @throws \Exception
     */
    public function getBalance(int $id, string $dateTo = null): string{
        if($dateTo && date("Y-m-d H:i:s", strtotime($dateTo)) != $dateTo){
            throw new \Exception("Wrong dateTo format!");
        } elseif(!$dateTo) {
            $dateTo = date("Y-m-d H:i:s");
        }
        return number_format($this->db->getOne("SELECT SUM(amount * if(from_user = ?, -1, 1)) FROM transactions WHERE ? IN(from_user,to_user) AND deleted IS NULL AND added <= ?",
            [$id, $id, $dateTo]), 2);
    }
}