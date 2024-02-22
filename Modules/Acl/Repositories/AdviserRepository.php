<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Acl\Entities\Adviser;
use Modules\Basic\Repositories\BasicRepository;

class AdviserRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'full_name', 'email', 'mobile', 'user_name', 'lang', 'info', 'gender', 'country_id', 'city_id', 'experience_year', 'bank_name',
        'bank_account', 'birthday', 'nationality_id', 'status', 'token', 'is_notification', 'rate'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Adviser::class;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function translationKey()
    {
        return $this->model->translationKey();
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $orderBy = [], $get = '',
        $recursiveRel = [], $moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), moreConditionForFirstLevel: $moreConditionForFirstLevel, orderBy: $orderBy,
            pagination: $pagination, perPage: $perPage, get: $get, recursiveRel: $recursiveRel);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), pagination: $pagination, perPage: $perPage,
            moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if(isset($request->password))
            {
                $request->merge(['password' => Hash::make($request->password)]);
            }
            if($id)
            {
                $data = $this->update($request->all(), $id);
            }else
            {
                $data = $this->create($request->all());
                $token = $data->createToken('nasooh adviser')->accessToken;
                $data->update(['token' => $token]);
                if($request->device)
                {
                    $data->device()->firstOrCreate(['device' => $request->device]);
                }
            }
            if(isset($request->category))
            {
                $data->category()->sync((array)$request->category);
            }
            if(isset($request->social) && !empty($request->social))
            {
                $data->adviser_social()->delete();
                foreach($request->social as $social)
                {
                    $data->adviser_social()->create($social);
                }
            }
            if(isset($request->document) && !empty($request->document))
            {
                $data->adviser_document()->delete();
                foreach($request->document as $documen)
                {
                    $data->adviser_document()->create(['value' => $documen]);
                }
            }
            if(isset($request->avatar[0]['file'], $request->avatar[0]['type']) && !empty($request->avatar[0]['file']) && !empty($request->avatar[0]['type']))
            {
                $this->checkMediaDelete($data, $request, mediaType()['am']);
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                    mediaType()['am']);
            }
            return $this->find($data->id);
        });
    }

    public function socialDelete($id)
    {
        $data = $this->find(user('adviser')->id);
        $social = $data->adviser_social()->where('id', $id)->first();
        if($social)
        {
            $social->delete();
            return true;
        }
        return null;
    }

    public function documentDelete($id)
    {
        $data = $this->find(user('adviser')->id);
        $document = $data->adviser_document()->where('id', $id)->first();
        if($document)
        {
            $document->delete();
            return true;
        }
        return null;
    }
}
