<?php

namespace Xsolla\SDK\Storage\Pdo;


use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Storage\PaymentsInterface;

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
        $update = $this->getCancelUpdateStatement();
        $update->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $update->execute();
        if ($update->rowCount() == 1) {
            return;
        }
        $select = $this->getCancelSelectStatement();
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

    abstract public function getCancelUpdateStatement();

    abstract public function getCancelSelectStatement();
} 