<?php

namespace App\Traits;

use App\Models\Referensi;

trait HelperMasterTraits
{
    public function getReferensi($id)
    {
        $data = Referensi::query()
            ->where('jenis_referensi_id', $id)
            ->select('id', 'nama')
            ->get();
        return $data;
    }
}
