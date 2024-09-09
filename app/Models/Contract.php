<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contract';

    protected $fillable = ['id_personal', 'start_date','end_date','salary', 'id_cargo', 'id_company', 'id_contract_modalities' , 'functions', 'path_contract', 'user_register','user_update','state'];


    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company', 'id');
    }

    public function contractModalities()
    {
        return $this->belongsTo(ContractModalitie::class, 'id_contract_modalities', 'id');
    }


}
