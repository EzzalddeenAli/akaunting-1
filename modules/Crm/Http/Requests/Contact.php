<?php

namespace Modules\Crm\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Contact extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $email = '';

        $type = $this->request->get('type', 'crm_contact');
        $company_id = $this->request->get('company_id');

        // Check if store or update
        if ($this->getMethod() == 'PATCH') {
            $id = $this->contact->getAttribute('id');
        } else {
            $id = null;
        }

        if (!empty($this->request->get('email'))) {
            $email = 'email|unique:contacts,NULL,' . $id . ',id,company_id,' . $company_id . ',type,' . $type . ',deleted_at,NULL';
        }

        return [
            // Contact
            'type' => 'required|string',
            'name' => 'required|string',
            'email' => $email,
            'enabled' => 'integer|boolean',

            // Crm Contact
            'phone' => 'required|string',
            'stage' => 'required|string',
            'owner_id' => 'required|integer',
            'born_at' => 'nullable|date_format:Y-m-d',
            'mobile' => 'nullable|string',
            'web_site' =>  'nullable|string',
            'fax_number' =>  'nullable|string',
            'address' =>  'nullable|string',
            'source' => 'required|string',
            'picture' => 'nullable',
            'note' =>  'nullable|string',
        ];
    }
}
