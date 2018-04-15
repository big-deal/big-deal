<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amo;

class RoistatController extends Controller
{
    public function webhook(Amo $amo)
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);

        if (isset($data['caller']) && strlen($data['caller']) > 0) {
            if (strlen($data['caller']) > 7) {
                $phone = substr($data['caller'], -10);
            } else {
                $phone = $data['caller'];
            }

            if (isset($data['visit_id']) && strlen($data['visit_id']) > 0) {
                $visit = $data['visit_id'];
            } else {
                $visit = $data['marker'];
            }

            $amo->roistat_calls()
                ->create(compact('phone', 'visit'));
        }
    }
}
