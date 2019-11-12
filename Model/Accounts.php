<?php

namespace Model;

use Core\Model;

class Accounts extends Model
{
    /**
     * Pobranie informacji o koncie
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array{
        return $this->db->getRow("SELECT * FROM accounts WHERE deleted IS NULL AND id = ?", $id);
    }

    /**
     * Dodanie/edycja konta użytkownika
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function save($data): array{
        $this->validate($data);
        if (!array_key_exists('id',$data)) {
            $rs = $this->db->execute("SELECT * FROM accounts WHERE 1=0");
            $sql = $this->db->getInsertSQL($rs,$data);
        } else {
            $rs = $this->db->execute("SELECT * FROM accounts WHERE id = ?", (int)$data['id']);
            $sql = $this->db->getUpdateSQL($rs,$data);
        }
        if (!$this->db->query($sql)) {
            throw new \Exception($this->db->errorMsg());
        }
        return $this->get($data['id'] ?? $this->db->Insert_ID());
    }

    /**
     * Usuwa konto użytkownika
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool{
        if(!$this->get($id)){
            throw new \Exception("Account doesn't exist or it has been already deleted!");
        }
        $rs = $this->db->execute("SELECT * FROM accounts WHERE id = ?",$id);
        $update = [
            'deleted' => time(),
        ];
        if (!$this->db->query($this->db->getUpdateSQL($rs,$update))) {
            throw new \Exception($this->db->errorMsg());
        }
        return true;
    }

    /**
     * Waliduje dane wejściowe
     *
     * @param array $data
     * @throws \Exception
     */
    private function validate(array &$data):void {
        if (!array_key_exists('id', $data)) {
            if (!$data['name']) {
                throw new \Exception("name field is require!");
            }
            if (!$data['surname']) {
                throw new \Exception("surname field is require!");
            }
        }
        if (array_key_exists('email', $data)) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("email format is wrong!");
            }
        }
        if (array_key_exists('added', $data)) {
            unset($data['added']);
        }
        if (array_key_exists('deleted', $data)) {
            unset($data['deleted']);
        }
    }
}