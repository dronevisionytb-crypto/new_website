<?php

class MissionRequest
{
    public int $id;
    public int $company_id;
    public int $user_id;
    public string $status;
    public string $site_name;
    public string $site_address;
    public string $site_postal_code;
    public string $site_city;
    public string $site_department;
    public ?string $site_gps;
    public ?float $installed_power_mwc;
    public string $plant_type;
    public string $mission_type;
    public ?string $mission_objective;
    public ?string $mission_context;
    public ?string $desired_period;
    public ?string $desired_duration;
    public ?string $site_access;
    public ?string $constraints;
    public ?string $cadastral_plan_url;
    public ?string $client_contact;
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
