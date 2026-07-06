<?php

class Invoice
{
    public int $id;
    public int $mission_request_id;
    public int $company_id;
    public ?float $amount_ht;
    public ?float $amount_ttc;
    public string $status;
    public ?string $file_path;
    public string $created_at;

    public function __construct(array $data = [])
    {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
}
