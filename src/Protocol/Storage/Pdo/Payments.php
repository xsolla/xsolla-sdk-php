<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;


use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Protocol\Storage\PaymentsInterface;

abstract class Payments implements PaymentsInterface
{
    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

    }

    public function cancel($invoiceId)
    {
        $update = $this->db->prepare($this->getCancelUpdateQuery());
        $update->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $update->execute();
        if ($update->rowCount() == 1) {
            return;
        }
        $select = $this->db->prepare($this->getCancelSelectQuery());
        $select->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new InvoiceNotFoundException();
        }
        if ($result['is_canceled'] != 1) {
            throw new \Exception('Temporary error');
        }
    }

    abstract public function getCancelUpdateQuery();

    abstract public function getCancelSelectQuery();
} 