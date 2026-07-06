<?php

class Company
{
    public int $id;
    public string $name;
    public ?string $address;
    public ?string $postal_code;
    public ?string $city;
    public ?string $department;
    public ?string $siret;
    public ?string $contact_name;
    public ?string $contact_email;
    public ?string $contact_phone;
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
