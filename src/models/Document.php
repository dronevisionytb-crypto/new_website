<?php

class Document
{
    public int $id;
    public string $title;
    public string $file_path;
    public int $is_signed;
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
